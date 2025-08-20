<template>
  <div class="table-responsive">
    <!-- Campo de busca -->
    <div v-if="searchEnabled" class="mb-3">
      <input type="text" class="form-control" placeholder="Buscar por título, gênero ou ano..." v-model="searchQuery"
        @input="resetPagination" />
    </div>
    
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
        <tr v-for="(movie, index) in paginatedMovies" :key="movie.id || index">
          <td class="text-center">
            <img v-if="movie.poster_path" :src="'https://image.tmdb.org/t/p/w200' + movie.poster_path"
              :alt="movie.title" class="img-thumbnail" style="max-width: 80px" />
            <span v-else class="text-muted">Sem imagem</span>
          </td>
          <td>{{ movie.title || 'N/A' }}</td>
          <td>            
            <span v-if="Array.isArray(movie.genre_names)">
              {{ movie.genre_names.join(', ') }}
            </span>
            <span v-else>
              {{ movie.genre_names || 'N/A' }}
            </span>
          </td>
          <td>
            {{ movie.release_date ? movie.release_date.substring(0, 4) : 'N/A' }}
          </td>
          <td class="text-center">
            
            <Button v-if="onRemove" icon="pi pi-trash" label="Excluir" class="p-button-danger p-button-sm me-2"
              @click="confirmRemove(movie)" :disabled="!movie.id" />
            
            <Button
              v-if="onAdd && movie.status"
              icon="pi pi-check"
              label="Adicionado"
              class="p-button-warning p-button-sm"
              disabled
            />
            
            <Button
              v-else-if="onAdd"
              icon="pi pi-plus"
              label="Adicionar"
              class="p-button-success p-button-sm"
              @click="confirmAdd(movie)"
            />

          </td>
        </tr>
      </tbody>
    </table>
    
    <div v-if="filteredMovies.length === 0" class="alert alert-warning mt-3">
      Nenhum filme encontrado.
    </div>
    
    <nav v-if="filteredMovies.length > 0 && totalPages > 1">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <button class="page-link" @click="prevPage">&laquo;</button>
        </li>
        <li class="page-item" v-for="page in pages" :key="page" :class="{ active: page === currentPage }">
          <button class="page-link" @click="goToPage(page)">{{ page }}</button>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <button class="page-link" @click="nextPage">&raquo;</button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
import Swal from 'sweetalert2';
import axios from 'axios';
import Button from 'primevue/button';


export default {
  name: 'MovieTable',
  props: {
    movies: {
      type: Array,
      required: true,
      default: () => []
    },
    searchEnabled: {
      type: Boolean,
      default: true
    },
    onRemove: {
      type: Boolean,
      default: false
    },
    onAdd: {
      type: Boolean,
      default: false
    },
    itemsPerPage: {
      type: Number,
      default: 10,
      validator: value => value > 0
    }
  },
  data() {
    return {
      searchQuery: '',
      currentPage: 1
    };
  },
  computed: {
    filteredMovies() {
      const query = this.searchQuery.toLowerCase();
      return this.movies.filter(movie => {
        const title = String(movie.title || '').toLowerCase();
        const genres = Array.isArray(movie.genre_names)
          ? movie.genre_names.join(', ').toLowerCase()
          : String(movie.genre_names || '').toLowerCase();
        const year = String(movie.release_date || '');

        return title.includes(query) || genres.includes(query) || year.includes(query);
      });
    },
    paginatedMovies() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      return this.filteredMovies.slice(start, start + this.itemsPerPage);
    },
    totalPages() {
      return Math.ceil(this.filteredMovies.length / this.itemsPerPage);
    },
    pages() {
      const maxVisible = 5;
      let start = Math.max(1, this.currentPage - Math.floor(maxVisible / 2));
      let end = Math.min(this.totalPages, start + maxVisible - 1);

      if (end - start + 1 < maxVisible) {
        start = Math.max(1, end - maxVisible + 1);
      }

      return Array.from({ length: end - start + 1 }, (_, i) => start + i);
    }
  },
  watch: {
    filteredMovies() {
      if (this.currentPage > this.totalPages && this.totalPages > 0) {
        this.currentPage = this.totalPages;
      }
    }
  },
  methods: {
    formatDate(dateString) {
      try {
        return new Date(dateString).toLocaleDateString('pt-BR');
      } catch {
        return dateString;
      }
    },
    resetPagination() {
      this.currentPage = 1;
    },
    prevPage() {
      if (this.currentPage > 1) this.currentPage--;
    },
    nextPage() {
      if (this.currentPage < this.totalPages) this.currentPage++;
    },
    goToPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },
    confirmRemove(movie) {
      Swal.fire({
        title: 'Tem certeza?',
        text: `Você está prestes a excluir "${movie.title}"`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
      }).then(result => {
        if (result.isConfirmed) {
          axios.delete(`http://movie-catalog/api/favorite/movies/${movie.id}`)
            .then(() => {
              this.$emit('remove', movie.id); // componente pai deve lidar com atualização
              this.showToast('Sucesso!', 'Filme excluído com sucesso.', 'success');
            })
            .catch(error => {
              console.error('Erro ao excluir filme:', error);
              this.showToast('Erro', 'Não foi possível excluir o filme.', 'error');
            });
        }
      });
    },
    confirmAdd(movie) {
      this.$emit('add', movie);
      this.showToast('Sucesso!', 'Filme adicionado com sucesso.', 'success');
    },
    showToast(title, text, icon) {
      Swal.fire({
        title,
        text,
        icon,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
    }
  }
};
</script>
