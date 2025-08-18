<?php

namespace App\Http\Controllers;

use App\Models\FavoriteMovie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function popular()
    {
        $response = Http::get("https://api.themoviedb.org/3/movie/popular", [
            'api_key' => env('TMDB_API_KEY'),
            'language' => 'pt-BR',
            'page' => 1
        ]);

        return $response->json('results');
    }

    public function myFavoriteMovies()
    {
        $response = FavoriteMovie::all();        

        return response()->json($response);
    }
    public function addFavoriteMovies(Request $request)
    {
        $genreMap = $this->getGenreMap(); // você já deve ter essa função

        $genreNames = collect($request->genre_ids)
            ->map(fn($id) => $genreMap[$id] ?? null)
            ->filter()
            ->values()
            ->toArray();

        $movie = FavoriteMovie::updateOrCreate(
            ['tmdb_id' => $request->id],
            [
                'title' => $request->title,
                'genres' => $genreNames,
                'poster_path' => $request->poster_path,
            ]
        );

        return response()->json(['message' => 'Filme salvo com sucesso!', 'movie' => $movie]);
    }

    private function getGenreMap()
    {
        $token = env('TMDB_BEARER_TOKEN');

        $response = Http::withToken($token)->get('https://api.themoviedb.org/3/genre/movie/list', [
            'language' => 'pt-BR',
        ]);

        return collect($response->json('genres'))->pluck('name', 'id')->toArray();
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

        // Se quiser apenas retornar os resultados em JSON:
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
