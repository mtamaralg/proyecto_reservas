import './bootstrap';
import { createApp } from 'vue';

// 1. Importamos tu nuevo esqueleto principal
import App from './App.vue'; 
// 2. Importamos el GPS
import router from './router'; 

// 3. Le decimos que cree la app usando App.vue
const app = createApp(App);

app.use(router);
app.mount('#app');