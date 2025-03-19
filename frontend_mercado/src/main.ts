

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import 'bootstrap/dist/css/bootstrap.min.css'; // Importa CSS do Bootstrap
import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // Importa JS do Bootstrap
const app = createApp(App)

app.use(router)

app.mount('#app')
