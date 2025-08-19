import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import AdminLayout from '../views/layouts/AdminLayout.vue';
import Dashboard from '../views/Admin/FavoriteMovies.vue';
import Movies from '../views/Admin/Movies.vue';
import FavoriteMovies from '../views/Admin/FavoriteMovies.vue';

const routes = [  
  {
    path: '/',
    component: AdminLayout,
    children: [
      { path: '', component: Dashboard },
      { path: 'movies', component: Movies },
      { path: 'favorite-movies', component: FavoriteMovies },
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;