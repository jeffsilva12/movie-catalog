<!-- MovieList.vue -->
<template>
  <div>
    <h2>Lista de Filmes</h2>

    <div v-if="loading">Carregando...</div>
    <div v-else-if="error">Erro ao buscar filmes: {{ error }}</div>
    <ul v-else>
      <li v-for="movie in movies" :key="movie.id">
        {{ movie.title }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

// States
const movies = ref([])
const loading = ref(true)
const error = ref(null)

// Função para buscar filmes
const fetchMovies = async () => {
  try {
    const response = await axios.get('http://movie-catalog/api/movies/popular')
    console.log('Filmes carregados:', response.data);
    
    movies.value = response.data
  } catch (err) {
    error.value = err.message || 'Erro desconhecido'
  } finally {
    loading.value = false
  }
}

// Executa ao montar o componente
onMounted(fetchMovies)
</script>

<style scoped>
ul {
  list-style: none;
  padding: 0;
}
li {
  padding: 5px 0;
}
</style>
