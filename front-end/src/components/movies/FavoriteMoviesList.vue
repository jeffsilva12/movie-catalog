<template>
  <div>
    <DataTable 
      :value="favoriteMovies" 
      :paginator="true" 
      :rows="10"
      paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
      :rowsPerPageOptions="[5,10,25,50]"
      currentPageReportTemplate="Showing {first} to {last} of {totalRecords} movies"
      responsiveLayout="scroll"
    >
      <Column field="poster_path" header="Poster" style="width: 100px">
        <template #body="{data}">
          <img 
            v-if="data.poster_path" 
            :src="'https://image.tmdb.org/t/p/w200' + data.poster_path" 
            :alt="data.title"
            class="movie-poster"
          >
          <div v-else class="poster-placeholder">
            <i class="pi pi-image" style="font-size: 2rem"></i>
          </div>
        </template>
      </Column>
      
      <Column field="title" header="Title" sortable>
        <template #body="{data}">
          <strong>{{ data.title }}</strong>
          <div class="text-sm text-color-secondary">
            {{ formatDate(data.release_date) }}
          </div>
        </template>
      </Column>
      
      <Column header="Actions" style="width: 120px">
        <template #body="{data}">
          <Button 
            icon="pi pi-trash" 
            class="p-button-rounded p-button-danger p-button-text"
            v-tooltip.top="'Remove from favorites'"
            @click="removeFromFavorites(data.id)"
          />
        </template>
      </Column>
    </DataTable>
    
    <div class="flex justify-content-end mt-3">
      <Button label="Close" icon="pi pi-times" @click="$emit('close')" />
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
  emits: ['close'],
  
  setup(props, { emit }) {
    const favoriteMovies = ref([]);

    const loadFavorites = async () => {
      try {
        const response = await axios.get('/api/favorite-movies');
        favoriteMovies.value = response.data;
      } catch (error) {
        console.error('Error loading favorites:', error);
      }
    };

    const removeFromFavorites = async (id) => {
      try {
        await axios.delete(`/api/favorite-movies/${id}`);
        await loadFavorites();
        // Show success toast
        console.log('Movie removed from favorites');
      } catch (error) {
        console.error('Error removing from favorites:', error);
      }
    };

    const formatDate = (dateString) => {
      if (!dateString) return 'N/A';
      return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      });
    };

    onMounted(() => {
      loadFavorites();
    });

    return {
      favoriteMovies,
      removeFromFavorites,
      formatDate
    };
  }
};
</script>

<style scoped>
.movie-poster {
  width: 80px;
  border-radius: 4px;
}

.poster-placeholder {
  width: 80px;
  height: 120px;
  background: #f0f0f0;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 4px;
  color: #6c757d;
}

.text-sm {
  font-size: 0.875rem;
}

.text-color-secondary {
  color: #6c757d;
}
</style>