import './assets/main.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'


import { createApp } from 'vue'
import { createPinia } from 'pinia'
import PrimeVue from 'primevue/config'
import Lara from '@primevue/themes/lara'
import 'primeicons/primeicons.css'
import Button from 'primevue/button';
import 'primeicons/primeicons.css';



import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(PrimeVue, {
  theme: {
    preset: Lara 
  }
})
app.component('Button', Button);

app.mount('#app')
