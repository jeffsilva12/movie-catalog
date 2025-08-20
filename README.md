

# 🎬 Projeto Catálogo de Filmes

Este é um projeto full-stack que integra **Laravel (com Laradock)** no back-end e **Vue.js** no front-end.  
O objetivo é permitir que o usuário busque filmes pelo nome, adicione aos favoritos, visualize e remova da lista de favoritos.

---

## 🚀 Tecnologias Utilizadas

- **Backend:** [Laravel](https://laravel.com/)  
- **Frontend:** [Vue.js](https://vuejs.org/)  
- **Ambiente de Desenvolvimento:** [Laradock](https://laradock.io/) com Docker  
- **Banco de Dados:** MySQL  

---

## ⚙️ Configuração do Ambiente

### 1. Clonar o repositório
```bash
git clone https://github.com/jeffsilva12/movie-catalog.git
cd movie-catalog
````

### 2. Configuração do Backend (Laravel com Laradock)

1. Acesse a pasta do **Laradock**:

   ```bash
   cd laradock
   ```

2. Copie o arquivo `.env.example` para `.env` e configure:

   ```bash
   cp .env.example .env
   ```

3. Configure o arquivo .env alterando a versão do PHP para 8.3:

   ```bash
   PHP_version=8.3
   ```

4. Configure o arquivo de **hosts**:

   * Abra o arquivo `hosts` do sistema:

     * Windows: `C:\Windows\System32\drivers\etc\hosts`
     * Linux/Mac: `/etc/hosts`
   * Adicione:

     ```
     127.0.0.1   movie-catalog
     ```

5. Crie o arquivo movie-catalog.conf dentro do diretório laradock/nginx/sites da seguinte forma:

  ```bash
   #server {
      #    listen 80;
      #    server_name laravel.com.co;
      #    return 301 https://laravel.com.co$request_uri;
      #}
      
      server {
      
          listen 80;
          listen [::]:80;
      
          # For https
          # listen 443 ssl;
          # listen [::]:443 ssl ipv6only=on;
          # ssl_certificate /etc/nginx/ssl/default.crt;
          # ssl_certificate_key /etc/nginx/ssl/default.key;
      
          server_name movie-catalog;
          root /var/www/movie-catalog/back-end/public;
          index index.php index.html index.htm;
      
          location / {
               try_files $uri $uri/ /index.php$is_args$args;
          }
      
          location ~ \.php$ {
              try_files $uri /index.php =404;
              fastcgi_pass php-upstream;
              fastcgi_index index.php;
              fastcgi_buffers 16 16k;
              fastcgi_buffer_size 32k;
              fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
              #fixes timeouts
              fastcgi_read_timeout 600;
              include fastcgi_params;
          }
      
          location ~ /\.ht {
              deny all;
          }
      
          location /.well-known/acme-challenge/ {
              root /var/www/letsencrypt/;
              log_not_found off;
          }
      
          error_log /var/log/nginx/laravel_error.log;
          access_log /var/log/nginx/laravel_access.log;
      }
  ```
     
6. Suba os containers:

   ```bash
   docker-compose up -d nginx mysql
   ```

7. Crie o Banco de dados e também crie e ajuste o .env do projeto dentro de /back-end conforme o banco de dados definido. Ex:

   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=movie-catalog
   DB_USERNAME=user
   DB_PASSWORD=secret 

8. Instale as dependências do Laravel:

   ```bash
   docker-compose exec workspace laradock
   composer install
   php artisan key:generate
   php artisan migrate
   ```

O backend estará disponível em:
👉 [http://movie-catalog](http://movie-catalog)

---

### 3. Configuração do Frontend (Vue.js)

1. Acesse a pasta `frontend`:

   ```bash
   cd frontend
   ```

2. Instale as dependências:

   ```bash
   npm install
   ```

3. Configure o arquivo `.env` do frontend para apontar para o backend:

   ```env
   VITE_API_URL=http://movie-catalog/api
   ```

4. Rode o servidor de desenvolvimento:

   ```bash
   npm run dev
   ```

## 🎯 Funcionalidades

* 🔍 **Buscar filmes** pelo nome
* ⭐ **Adicionar filmes aos favoritos**
* 📋 **Listar filmes favoritos**
* ❌ **Remover filmes favoritos**

Datas de lançamento dos filmes são exibidas no formato **brasileiro (DD/MM/YYYY)**.

---

## ▶️ Como Rodar o Projeto

1. Subir containers do backend (Laradock + Laravel)
2. Configurar hosts para o domínio `movie-catalog`
3. Rodar o frontend com Vue.js
4. Acessar a aplicação pelo navegador

---

## 🔑 Como Obter a Chave da API do TMDB

```bash
1. Acesse o site oficial do TMDB:
   https://www.themoviedb.org/

2. Crie uma Conta:
   - Clique em "Entrar" no canto superior direito e depois em "Cadastrar-se".
   - Preencha as informações necessárias para criar uma conta gratuita.

3. Acesse as Configurações da API:
   - Após fazer login, clique na sua foto de perfil no canto superior direito.
   - No menu que aparece, selecione **Configurações**.

4. Solicite uma Chave de API:
   - Na página de configurações, vá até a seção **API** na barra lateral esquerda.
   - Clique em **Solicitar uma chave de API**.
   - Selecione a opção **Developer** quando perguntado sobre o tipo de uso.

5. Preencha o Formulário de Inscrição:
   - **URL do site:** http://localhost:3000 (ou a porta do seu projeto local)
   - **Descrição da Aplicação:** Forneça uma breve descrição do seu projeto (ex: "App pessoal para descobrir filmes").
   - Aceite os Termos de Uso e clique em **Enviar**.

6. Copie sua Chave de API:
   - Após a aprovação (geralmente instantânea), você será redirecionado para a página da sua API.
   - Lá estará a seção **API Key (v3 auth)** → copie esse valor.

```

## Adicionar chave ao projeto
```bash
Adicione a seguinte linha, colando a chave que você copiou no .env do back-end:
TMDB_API_KEY=sua_chave_api_aqui_123

````


## 👨‍💻 Autor

Desenvolvido por **Jeff** 🚀

