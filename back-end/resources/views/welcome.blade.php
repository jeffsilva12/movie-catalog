<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>API de Filmes - Laravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body>

<header>
    <h1>API de Filmes - Laravel</h1>
    <p>Bem-vindo! Explore abaixo as rotas disponíveis da API.</p>
</header>

<div class="container">
    <h2> Rotas de API Disponíveis</h2>
    <ul>
        <li>
            <span class="method">GET</span>
            <code>/api/movies/popular</code> <br>
            Retorna uma lista de filmes populares.
        </li>
        <li>
            <span class="method">GET</span>
            <code>/api/favorite/movies</code> <br>
            Lista os filmes favoritos do usuário.
        </li>
        <li>
            <span class="method">POST</span>
            <code>/api/add-movie</code> <br>
            Adiciona um filme aos favoritos.
        </li>
        <li>
            <span class="method">GET</span>
            <code>/api/genre/movies</code> <br>
            Retorna o mapeamento de gêneros disponíveis.
        </li>
        <li>
            <span class="method">DELETE</span>
            <code>/api/favorite/movies/{id}</code> <br>
            Remove um filme da lista de favoritos.
        </li>
    </ul>
</div>

</body>
</html>
