<template>
  <div class="layout-wrapper">
    <!-- Sidebar Fixo -->
    <div class="layout-sidebar fixed h-screen" :class="{ 'active': sidebarVisible }">
      <div class="flex justify-content-end p-2">
        <Button 
          icon="pi pi-times" 
          @click="toggleSidebar"
          class="p-button-text p-button-sm lg:hidden"
          v-tooltip="'Ocultar menu'"
        />
      </div>
      <Menubar :model="menuItems" vertical class="border-none h-full" />
      
    </div>

    <!-- Conteúdo Principal -->
    <div class="layout-main">
      <!-- Topbar (apenas quando sidebar estiver oculto) -->
      <Menubar class="layout-topbar" v-if="!sidebarVisible">
        <template #start>
          <Button 
            icon="pi pi-bars" 
            @click="toggleSidebar"
            class="p-button-text"
            v-tooltip="'Mostrar menu'"
          />
          <!-- <span class="ml-3 font-semibold">Administração</span> -->
        </template>
      </Menubar>

      <!-- Área de Conteúdo -->
      <div class="layout-content">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import Menubar from 'primevue/menubar';
import Button from 'primevue/button';
import { useRouter } from 'vue-router'

const sidebarVisible = ref(true);
const isMobile = ref(false);
const router = useRouter()

const checkScreenSize = () => {
  isMobile.value = window.innerWidth < 960;
  if (isMobile.value) {
    sidebarVisible.value = false;
  } else {
    sidebarVisible.value = true;
  }
};

const toggleSidebar = () => {
  sidebarVisible.value = !sidebarVisible.value;
};

onMounted(() => {
  checkScreenSize();
  window.addEventListener('resize', checkScreenSize);
});

onBeforeUnmount(() => {
  window.removeEventListener('resize', checkScreenSize);
});

const menuItems = ref([
  {
    label: 'Dashboard',
    icon: 'pi pi-home',
    command: () => router.push('/admin')
  },
  {
    label: 'Filmes',
    icon: 'pi pi-video',
    command: () => router.push('/admin/movies')
  },
  {
    label: 'Configurações',
    icon: 'pi pi-cog',
    command: () => router.push('/admin/settings')
  }
])
</script>

