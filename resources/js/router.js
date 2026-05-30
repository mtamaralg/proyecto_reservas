import { createRouter, createWebHistory } from 'vue-router';

// 1. Importamos todos los componentes que hemos creado
// (Nota: si a tus archivos les llamaste recursos.vue en lugar de RecursosList.vue, cámbialo aquí)
// Fíjate bien en las rutas entre comillas, ¡ahora coinciden al 100% con tu foto!
import CalendariosList from './components/calendarioList.vue';
import CategoriasList from './components/categoriaList.vue';
import RecursosList from './components/recursos.vue';
import ReservasList from './components/reservaList.vue';
import TramosHorariosList from './components/tramosHorariosList.vue';
// 2. Definimos todas las rutas y el componente al que apuntan
const routes = [
    // Si alguien entra a la raíz de la web (/), lo redirigimos automáticamente a recursos
    { path: '/', redirect: '/recursos' },
    
    // Tus 5 rutas principales
    { path: '/recursos', component: RecursosList },
    { path: '/categorias', component: CategoriasList },
    { path: '/calendarios', component: CalendariosList },
    { path: '/reservas', component: ReservasList },
    { path: '/tramos-horarios', component: TramosHorariosList },
    { path: '/recursosForm', component: recursosForm }
];

// 3. Creamos el enrutador de Vue
const router = createRouter({
    history: createWebHistory(),
    routes
});

// 4. Lo exportamos para poder conectarlo en el siguiente paso
export default router;