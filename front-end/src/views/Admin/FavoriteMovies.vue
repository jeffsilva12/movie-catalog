<template>
  <div class="container mt-4">
    <h2 class="mb-3">Meus Filmes Favoritos</h2>

    <MovieTable
      :movies="movies"
      :onRemove="true"
      @remove="handleRemove"
    />
  </div>
</template>

<script>
import axios from "axios";
import MovieTable from "@/components/MovieTable.vue";

axios.defaults.baseURL = "http://movie-catalog/api";

export default {
  name: "FavoriteMovies",
  components: { MovieTable },
  data() {
    return {
      movies: [],
      loading: true,
    };
  },
  methods: {
    loadFavorites() {
      this.loading = true;
      axios
        .get("/favorite/movies")
        .then((response) => {
          this.movies = response.data;
        })
        .finally(() => {
          this.loading = false;
        });
    },
    handleRemove(id) {      
      this.loadFavorites();
    },
  },
  mounted() {
    this.loadFavorites();
  },
};
</script>
