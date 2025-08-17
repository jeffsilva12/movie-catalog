import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import AdminLayout from '../views/layouts/AdminLayout.vue';
import Dashboard from '../views/Admin/Dashboard.vue';
import Movies from '../views/Admin/Movies.vue';
import Users from '../views/Admin/Users.vue';

const routes = [
  { path: '/', component: Login },
  {
    path: '/admin',
    component: AdminLayout,
    children: [
      { path: '', component: Dashboard },
      { path: 'users', component: Users },
      { path: 'movies', component: Movies },
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;