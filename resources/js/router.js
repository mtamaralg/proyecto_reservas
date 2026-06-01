import { createRouter, createWebHistory } from 'vue-router';

// 1. IMPORTACIONES DE LOS COMPONENTES DE LISTAS (Vistas principales)
import CalendariosList from './components/calendarioList.vue';
import CategoriasList from './components/categoriaList.vue';
import RecursosList from './components/recursos.vue';
import ReservasList from './components/reservaList.vue';
import TramosHorariosList from './components/tramosHorariosList.vue';

// 2. IMPORTACIONES DE LOS COMPONENTES DE FORMULARIOS (Crear/Editar)
import RecursosForm from './components/RecursosForm.vue';
import CalendarioForm from './components/CalendarioForm.vue';
import CategoriaForm from './components/CategoriaForm.vue';
import ReservaForm from './components/ReservaForm.vue';
import TramosHorariosForm from './components/TramosHorariosForm.vue';


// 3. DEFINICIÓN DE RUTAS (El GPS)
const routes = [
    // Redirección inicial
    { path: '/', redirect: '/recursos' },
    
    // --- RUTAS DE RECURSOS ---
    { path: '/recursos', component: RecursosList },
    { path: '/recursos/nuevo', component: RecursosForm },
    { path: '/recursos/:recursoId/editar', component: RecursosForm, props: true },

    // --- RUTAS DE CATEGORÍAS ---
    { path: '/categorias', component: CategoriasList },
    { path: '/categorias/nuevo', component: CategoriaForm },
    { path: '/categorias/:categoriaId/editar', component: CategoriaForm, props: true },

    // --- RUTAS DE CALENDARIOS ---
    { path: '/calendarios', component: CalendariosList },
    { path: '/calendarios/nuevo', component: CalendarioForm },
    { path: '/calendarios/:calendarioId/editar', component: CalendarioForm, props: true },

    // --- RUTAS DE RESERVAS ---
    { path: '/reservas', component: ReservasList },
    { path: '/reservas/nueva', component: ReservaForm },
    { path: '/reservas/:reservaId/editar', component: ReservaForm, props: true },

    // --- RUTAS DE TRAMOS HORARIOS ---
    { path: '/tramos-horarios', component: TramosHorariosList },
    { path: '/tramos-horarios/nuevo', component: TramosHorariosForm },
    { path: '/tramos-horarios/:tramoId/editar', component: TramosHorariosForm, props: true }
];

// 4. CREACIÓN Y EXPORTACIÓN DEL ENRUTADOR
const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;