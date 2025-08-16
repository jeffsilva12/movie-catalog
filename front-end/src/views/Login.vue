<template>
  <div class="surface-ground flex align-items-center justify-content-center min-h-screen">
    <Card class="w-full md:w-30rem">
      <template #title> Acessar Sistema </template>
      <template #content>
        <div class="flex flex-column gap-3">
          <InputText v-model="form.email" placeholder="Email" />
          <Password v-model="form.password" placeholder="Senha" toggleMask />
          <Button label="Entrar" severity="primary" @click="handleLogin" />
        </div>
      </template>
    </Card>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Button from 'primevue/button';

const router = useRouter();
const form = ref({ email: '', password: '' });

const handleLogin = () => {
  // Simulando login (substitua pela chamada real ao Laravel)
  if (form.value.email && form.value.password) {
    router.push('/admin');
  }
};
</script>