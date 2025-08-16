<template>
  <div class="flex justify-content-center align-items-center min-h-screen">
    <Card class="w-full md:w-25rem">
      <template #title> Login </template>
      <template #content>
        <div class="flex flex-column gap-3">
          <InputText v-model="email" placeholder="Email" />
          <Password v-model="password" placeholder="Senha" toggleMask />
          <Button label="Entrar" @click="handleLogin" />
        </div>
      </template>
    </Card>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Card from 'primevue/card'
import InputText from 'primevue/inputtext'
import Password from 'primevue/password'
import Button from 'primevue/button'

const email = ref('')
const password = ref('')

const handleLogin = () => {
  // Lógica de autenticação (ex: chamada API Laravel)
  console.log(email.value, password.value)
}
</script>

<style scoped>
.min-h-screen {
  min-height: 100vh;
}
</style>