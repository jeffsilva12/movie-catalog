<template>
  <div class="layout-wrapper">

    <Sidebar v-model:visible="sidebarVisible" position="left" :modal="isMobile" dismissable
      :style="{ width: isMobile ? '100%' : '18rem' }" class="layout-sidebar">
      <div class="sidebar-logo text-center p-0">
        <router-link to="/">
          <img src="@/assets/logo1.jpg" alt="Logo" class="img-fluid image-logo" />
        </router-link>
      </div>


      <Menubar :model="menuItems" vertical class="border-none" />
    </Sidebar>

    <div class="layout-main">
      <Menubar class="layout-topbar" v-if="!sidebarVisible">
        <template #start>
          <Button icon="pi pi-bars" class="p-button-text" @click="sidebarVisible = true" v-tooltip="'Abrir menu'" />
        </template>
      </Menubar>

      <div class="layout-content">
        <router-view />
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import Sidebar from 'primevue/sidebar';
import Menubar from 'primevue/menubar';
import Button from 'primevue/button';
import { useRouter } from 'vue-router';

const router = useRouter();
const sidebarVisible = ref(true);
const isMobile = ref(false);

const checkScreenSize = () => {
  isMobile.value = window.innerWidth < 960;
  sidebarVisible.value = !isMobile.value;
};

onMounted(() => {
  checkScreenSize();
  window.addEventListener('resize', checkScreenSize);
});
onBeforeUnmount(() => {
  window.removeEventListener('resize', checkScreenSize);
});

const menuItems = [
  { label: 'Filmes Favoritos', icon: 'pi pi-star', command: () => router.push('/favorite-movies') },
  { label: 'Filmes', icon: 'pi pi-video', command: () => router.push('/movies') }
];
</script>
