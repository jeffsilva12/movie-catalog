<template>
  <div class="card">
    <Toolbar class="mb-4">
      <template #start>
        <h2>Gerenciar Usuários</h2>
      </template>
      <template #end>
        <Button 
          label="Novo Usuário" 
          icon="pi pi-plus" 
          @click="openNew" 
        />
      </template>
    </Toolbar>

    <!-- Tabela de Usuários -->
    <DataTable 
      :value="users" 
      paginator :rows="10" 
      stripedRows
    >
      <Column field="id" header="ID" sortable></Column>
      <Column field="name" header="Nome" sortable></Column>
      <Column field="email" header="Email" sortable></Column>
      <Column header="Ações">
        <template #body="{ data }">
          <Button 
            icon="pi pi-pencil" 
            @click="editUser(data)" 
            class="p-button-text" 
          />
          <Button 
            icon="pi pi-trash" 
            @click="confirmDelete(data)" 
            class="p-button-text p-button-danger" 
          />
        </template>
      </Column>
    </DataTable>

    <!-- Diálogo de Edição/Criação -->
    <Dialog 
      v-model:visible="userDialog" 
      :header="user.id ? 'Editar Usuário' : 'Novo Usuário'"
    >
      <div class="flex flex-column gap-3">
        <InputText v-model="user.name" placeholder="Nome" />
        <InputText v-model="user.email" placeholder="Email" />
        <Password 
          v-model="user.password" 
          placeholder="Senha" 
          toggleMask 
          :feedback="false" 
        />
      </div>
      <template #footer>
        <Button label="Cancelar" @click="userDialog = false" text />
        <Button label="Salvar" @click="saveUser" severity="success" />
      </template>
    </Dialog>

    <!-- Confirmação de Exclusão -->
    <Dialog 
      v-model:visible="deleteDialog" 
      header="Confirmar" 
      :modal="true"
    >
      <p>Tem certeza que deseja excluir este usuário?</p>
      <template #footer>
        <Button label="Não" @click="deleteDialog = false" text />
        <Button label="Sim" @click="deleteUser" severity="danger" />
      </template>
    </Dialog>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useToast } from 'primevue/usetoast';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';

const toast = useToast();
const users = ref([]);
const userDialog = ref(false);
const deleteDialog = ref(false);
const user = ref({ id: null, name: '', email: '', password: '' });

// Simulação de dados (substitua pela chamada API Laravel)
onMounted(() => {
  users.value = [
    { id: 1, name: 'Admin', email: 'admin@teste.com' },
    { id: 2, name: 'Usuário', email: 'user@teste.com' }
  ];
});

const openNew = () => {
  user.value = { id: null, name: '', email: '', password: '' };
  userDialog.value = true;
};

const editUser = (data) => {
  user.value = { ...data, password: '' };
  userDialog.value = true;
};

const confirmDelete = (data) => {
  user.value = data;
  deleteDialog.value = true;
};

const saveUser = () => {
  // Simulação (substitua pela API)
  if (user.value.id) {
    const index = users.value.findIndex(u => u.id === user.value.id);
    users.value[index] = { ...user.value };
    toast.add({ severity: 'success', summary: 'Sucesso!', detail: 'Usuário atualizado' });
  } else {
    user.value.id = users.value.length + 1;
    users.value.push(user.value);
    toast.add({ severity: 'success', summary: 'Sucesso!', detail: 'Usuário criado' });
  }
  userDialog.value = false;
};

const deleteUser = () => {
  users.value = users.value.filter(u => u.id !== user.value.id);
  deleteDialog.value = false;
  toast.add({ severity: 'success', summary: 'Sucesso!', detail: 'Usuário excluído' });
};
</script>