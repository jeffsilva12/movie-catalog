<template>
  <div class="dashboard-container">
    <div class="flex justify-content-between align-items-center mb-4">
      <h2>Meus Filmes Favoritos</h2>
      <Button 
        icon="pi pi-refresh" 
        label="Refresh" 
        class="p-button-text" 
        @click="refreshFavorites"
      />
    </div>
    
    <Card>
      <template #title>
        <div class="flex align-items-center gap-2">
          <i class="pi pi-star"></i>
          <span>Favorite Movies</span>
        </div>
      </template>
      <template #subtitle>
        <div class="flex flex-column md:flex-row md:align-items-center md:justify-content-between gap-3">
          <span class="text-sm">{{ filteredCount }} of {{ totalCount }} movies</span>
          <div class="flex gap-2">
            <span class="p-input-icon-left">
              <i class="pi pi-search" />
              <InputText 
                v-model="searchQuery" 
                placeholder="Search favorites..." 
                @input="applyFilters"
              />
            </span>
            <Dropdown 
              v-model="selectedYear" 
              :options="years" 
              optionLabel="label" 
              optionValue="value" 
              placeholder="Filter by year" 
              class="w-10rem"
              @change="applyFilters"
            />
          </div>
        </div>
      </template>
      <template #content>
        <DataTable 
          :value="filteredMovies" 
          :paginator="true" 
          :rows="10"
          :loading="loading"
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
          
          <Column field="vote_average" header="Rating" sortable style="width: 120px">
            <template #body="{data}">
              <Rating 
                :modelValue="data.vote_average / 2" 
                :readonly="true" 
                :cancel="false" 
              />
              <div class="text-sm">
                {{ data.vote_average?.toFixed(1) || 'N/A' }} ({{ data.vote_count || 0 }} votes)
              </div>
            </template>
          </Column>
          
          <Column header="Actions" style="width: 120px">
            <template #body="{data}">
              <Button 
                icon="pi pi-trash" 
                class="p-button-rounded p-button-danger p-button-text"
                v-tooltip.top="'Remove from favorites'"
                @click="confirmRemove(data.id)"
              />
            </template>
          </Column>
          
          <template #empty>
            <div class="text-center py-4">
              <i class="pi pi-exclamation-circle" style="font-size: 2rem"></i>
              <p>No favorite movies found</p>
              <p v-if="searchQuery || selectedYear" class="text-sm">
                Try adjusting your search filters
              </p>
            </div>
          </template>
        </DataTable>
      </template>
    </Card>
    
    <Dialog 
      v-model:visible="showConfirmDialog" 
      :style="{width: '350px'}" 
      header="Confirm" 
      :modal="true"
    >
      <div class="confirmation-content">
        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
        <span>Are you sure you want to remove this movie?</span>
      </div>
      <template #footer>
        <Button 
          label="No" 
          icon="pi pi-times" 
          @click="showConfirmDialog = false" 
          class="p-button-text" 
        />
        <Button 
          label="Yes" 
          icon="pi pi-check" 
          @click="removeFavorite" 
          class="p-button-danger" 
          autofocus
        />
      </template>
    </Dialog>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

export default {
  setup() {
    const favorites = ref([]);
    const loading = ref(false);
    const searchQuery = ref('');
    const selectedYear = ref(null);
    const showConfirmDialog = ref(false);
    const movieToRemove = ref(null);
    
    // Generate years from current year back to 1900
    const years = computed(() => {
      const currentYear = new Date().getFullYear();
      return Array.from({length: currentYear - 1900 + 1}, (_, i) => ({
        label: (currentYear - i).toString(),
        value: (currentYear - i).toString()
      }));
    });
    
    const filteredMovies = computed(() => {
      return favorites.value.filter(movie => {
        const matchesSearch = movie.title.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesYear = selectedYear.value 
          ? new Date(movie.release_date).getFullYear().toString() === selectedYear.value
          : true;
        return matchesSearch && matchesYear;
      });
    });
    
    const totalCount = computed(() => favorites.value.length);
    const filteredCount = computed(() => filteredMovies.value.length);
    
    const loadFavorites = async () => {
      loading.value = true;
      try {
        const response = await axios.get('/api/favorite-movies');
        favorites.value = response.data;
      } catch (error) {
        console.error('Error loading favorites:', error);
      } finally {
        loading.value = false;
      }
    };
    
    const confirmRemove = (id) => {
      movieToRemove.value = id;
      showConfirmDialog.value = true;
    };
    
    const removeFavorite = async () => {
      try {
        await axios.delete(`/api/favorite-movies/${movieToRemove.value}`);
        await loadFavorites();
        showConfirmDialog.value = false;
        // Show success toast
        console.log('Movie removed from favorites');
      } catch (error) {
        console.error('Error removing favorite:', error);
      }
    };
    
    const refreshFavorites = () => {
      loadFavorites();
    };
    
    const applyFilters = () => {
      // Filtro é aplicado automaticamente pelo computed property
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
      favorites,
      loading,
      searchQuery,
      selectedYear,
      years,
      filteredMovies,
      totalCount,
      filteredCount,
      showConfirmDialog,
      confirmRemove,
      removeFavorite,
      refreshFavorites,
      applyFilters,
      formatDate
    };
  }
};
</script>

<style scoped>
.dashboard-container {
  padding: 1rem;
}

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

.confirmation-content {
  display: flex;
  align-items: center;
}
</style>