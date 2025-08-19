<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>API de Filmes - Laravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background: #0d6efd;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            padding: 30px;
        }
        h1 {
            margin-top: 0;
            font-size: 28px;
        }
        ul {
            list-style: none;
            padding-left: 0;
        }
        li {
            background: #f1f5f9;
            margin-bottom: 12px;
            padding: 16px;
            border-left: 5px solid #0d6efd;
            border-radius: 4px;
        }
        code {
            background: #e2e8f0;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 14px;
        }
        .method {
            font-weight: bold;
            margin-right: 10px;
            color: #0d6efd;
        }
    </style>
</head>
<body>

<header>
    <h1>🎬 API de Filmes - Laravel</h1>
    <p>Bem-vindo! Explore abaixo as rotas disponíveis da API.</p>
</header>

<div class="container">
    <h2>📌 Rotas de API Disponíveis</h2>
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
