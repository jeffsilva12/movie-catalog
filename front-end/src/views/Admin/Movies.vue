<template>
  <div class="container mt-4">
    <h2 class="mb-4">Lista de Filmes</h2>

    <div v-if="loading" class="text-muted">Carregando...</div>
    <div v-else-if="error" class="text-danger">Erro: {{ error }}</div>

    <MovieTable
      v-else
      :movies="movies"
      :onAdd="true"
      :searchEnabled="true"
      @add="addToFavorites"
    />

    <div v-if="successMessage" class="alert alert-success mt-3" role="alert">
      {{ successMessage }}
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import MovieTable from '@/components/MovieTable.vue'

axios.defaults.baseURL = 'http://movie-catalog/api'
const movies = ref([])
const loading = ref(true)
const error = ref(null)
const successMessage = ref('')

const fetchMovies = async () => {
  try {
    const response = await axios.get('/movies/popular')
    movies.value = response.data
  } catch (err) {
    error.value = err.message || 'Erro desconhecido'
  } finally {
    loading.value = false
  }
}

onMounted(fetchMovies)

const addToFavorites = async (movie) => {
  try {
    await axios.post('http://movie-catalog/api/add-movie', movie)

    successMessage.value = `Filme "${movie.title}" adicionado aos favoritos!`

    setTimeout(() => {
      successMessage.value = ''
    }, 3000)
  } catch (err) {
    error.value = `Erro ao adicionar favorito: ${err.message || 'Erro desconhecido'}`
  }
}
</script>
