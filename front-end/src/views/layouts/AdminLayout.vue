<template>
  <div class="layout-wrapper">
    <!-- Sidebar via PrimeVue Sidebar -->
    <Sidebar
      v-model:visible="sidebarVisible"
      position="left"
      :modal="isMobile"
      dismissable
      :style="{ width: isMobile ? '100%' : '18rem' }"
      class="layout-sidebar"
    >
      <div class="p-px-3 p-pt-2 flex justify-content-end">
        <Button
          icon=""
          class="p-button-text p-button-sm"
          @click="sidebarVisible = false"
          v-tooltip="'Fechar menu'"
        />
      </div>
      <Menubar :model="menuItems" vertical class="border-none" />
    </Sidebar>

    <!-- Conteúdo Principal -->
    <div class="layout-main">
      <!-- Topbar mobile -->
      <Menubar class="layout-topbar" v-if="!sidebarVisible">
        <template #start>
          <Button
            icon="pi pi-bars"
            class="p-button-text"
            @click="sidebarVisible = true"
            v-tooltip="'Abrir menu'"
          />
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
  { label: 'Favoritos', icon: 'pi pi-star', command: () => router.push('/admin') },
  { label: 'Filmes', icon: 'pi pi-video', command: () => router.push('/admin/movies') }
];
</script>
