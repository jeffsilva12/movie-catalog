<?php

namespace App\Http\Controllers;

use App\Models\FavoriteMovie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    public function popular()
    {

        $favorite_movies_ids = FavoriteMovie::pluck('tmdb_id')->toArray();

        $response = Http::get("https://api.themoviedb.org/3/movie/popular", [
            'api_key' => env('TMDB_API_KEY'),
            'language' => 'pt-BR',
            'page' => 1
        ]);

        $movies = $response->json('results') ?? [];


        $genreMap = $this->getGenreMap();

        return $movies = array_map(function ($movie) use ($genreMap, $favorite_movies_ids) {
            if (in_array($movie['id'], $favorite_movies_ids)) {
                $movie['status'] = 'adicionado';
            }

            $movie['genre_names'] = collect($movie['genre_ids'] ?? [])
                ->map(fn($id) => $genreMap[$id] ?? 'Desconhecido')
                ->all();

            return $movie;
        }, $movies);
    }

    public function myFavoriteMovies()
    {
        $movies = FavoriteMovie::all()->map(function ($movie) {
            $movie->genre_names = is_array($movie->genres)
                ? $movie->genres // já são os nomes!
                : json_decode($movie->genres, true); // fallback caso esteja em string JSON

            return $movie;
        });

        return response()->json($movies);
    }


    public function addFavoriteMovies(Request $request)
    {
        Log::info('📦 Dados recebidos:', $request->all());
        $movie = FavoriteMovie::updateOrCreate(
            ['tmdb_id' => $request->id],
            [
                'title' => $request->title,
                'genres' => json_encode($request->genre_names),
                'poster_path' => $request->poster_path,
                'release_date' => $request->release_date ?? null,
            ]
        );

        return response()->json([
            'message' => 'Filme salvo com sucesso!',
            'movie' => $movie
        ]);
    }


    private function getGenreMap()
    {
        $response = Http::get("https://api.themoviedb.org/3/genre/movie/list", [
            'api_key' => env('TMDB_API_KEY'),
            'language' => 'pt-BR'
        ]);

        $genres = $response->json('genres') ?? [];

        return collect($genres)->pluck('name', 'id')->toArray();
    }


    public function searchMovies(Request $request)
    {
        $response = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJiYWZkOGQ4NTFiMGFkN2U5MTJhNWE3YmI2ZTFiOGRjMiIsIm5iZiI6MTc1NTM3NDM4NC4xMjUsInN1YiI6IjY4YTBlMzMwY2EwN2NkM2NkOTg2Zjk3NiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.lx8WZoEbRi1oCxqT-3MenobPmZmD2c8KGyAQeBXOsNI')
            ->acceptJson()
            ->get('https://api.themoviedb.org/3/account/22232988/watchlist/movies', [
                'language' => 'en-US',
                'page' => 1,
                'sort_by' => 'created_at.asc',
            ]);

        return response()->json($response->json('results'));
    }

    public function destroy($id)
    {
        $movie = FavoriteMovie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Filme não encontrado'], 404);
        }

        $movie->delete();

        return response()->json(['message' => 'Filme removido com sucesso']);
    }
}
