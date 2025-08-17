<template>
  <div class="movie-search">
    <!-- Seu conteúdo existente do MovieSearch -->
    <Card>
      <template #title>
        <div class="flex justify-content-between align-items-center">
          <span>Movie Search</span>
          <Button 
            icon="pi pi-star" 
            label="My Favorites" 
            class="p-button-secondary" 
            @click="showFavorites = true" 
          />
        </div>
      </template>
      
      <!-- Restante do seu template -->
    </Card>
    
    <!-- Dialogs e outros elementos -->
  </div>
</template>

<script setup>
// Importações do seu script existente
import { ref, onMounted } from 'vue';
import axios from '@/axios';

// Seu código existente do setup
const searchQuery = ref('');
const selectedYear = ref(null);
const movies = ref([]);
// ... restante das variáveis e funções

onMounted(() => {
  loadFavorites();
});

// ... restante da lógica
</script>

<style scoped>
.movie-search {
  width: 100%;
}

/* Mantenha seus estilos existentes */
</style>