<!-- components/MovieTable.vue -->
<template>
  <div class="table-responsive">
    <!-- Campo de busca opcional -->
    <div v-if="searchEnabled" class="mb-3">
      <input
        type="text"
        class="form-control"
        placeholder="Buscar por título, gênero ou ano..."
        v-model="searchQuery"
      />
    </div>

    <!-- Tabela -->
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
        <tr>
          <th class="fw-bold text-center">Poster</th>
          <th class="fw-bold text-center">Título</th>
          <th class="fw-bold text-center">Gênero</th>
          <th class="fw-bold text-center">Ano</th>
          <th class="fw-bold text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="movie in filteredMovies" :key="movie.id">
          <td class="text-center">
            <img
              v-if="movie.poster_path"
              :src="'https://image.tmdb.org/t/p/w200' + movie.poster_path"
              :alt="movie.title"
              class="img-thumbnail"
              style="max-width: 80px"
            />
            <span v-else class="text-muted">Sem imagem</span>
          </td>
          <td>{{ movie.title }}</td>
          <td>{{ movie.genres || 'N/A' }}</td>
          <td>{{ movie.release_date ? new Date(movie.release_date).toLocaleDateString('pt-BR') : 'N/A' }}</td>
          <td class="text-center">
            <!-- Botão de ação customizável -->
            <button
              v-if="onRemove"
              class="btn btn-danger btn-sm me-2"
              @click="$emit('remove', movie.id)"
            >
              Remover
            </button>
            <button
              v-if="onAdd"
              class="btn btn-success btn-sm"
              @click="$emit('add', movie)"
            >
              +
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <div v-if="filteredMovies.length === 0" class="alert alert-warning mt-3">
      Nenhum filme encontrado.
    </div>
  </div>
</template>

<script>
export default {
  name: "MovieTable",
  props: {
    movies: {
      type: Array,
      required: true,
    },
    searchEnabled: {
      type: Boolean,
      default: true,
    },
    onRemove: {
      type: Boolean,
      default: false,
    },
    onAdd: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      searchQuery: "",
    };
  },
  computed: {
    filteredMovies() {
      const q = this.searchQuery.toLowerCase();
      return this.movies.filter((movie) => {
        return (
          movie.title?.toLowerCase().includes(q) ||
          movie.genres?.toLowerCase().includes(q) ||
          movie.release_date?.toString().includes(q)
        );
      });
    },
  },
};
</script>
