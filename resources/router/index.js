// 1. Primero importamos los componentes que hemos creado
// (Asegúrate de que la ruta './components/...' coincide con dónde tienes tus archivos)
import CalendariosList from '../components/calendarios.vue';
import CategoriasList from '../components/categorias.vue';
import RecursosList from '../components/recursos.vue';
import ReservasList from '../components/reservas.vue';
import TramosHorariosList from '../components/tramos.vue';

// 2. Definimos las rutas exactas como pide tu profe
const routes = [
    { path: '/calendarios', component: CalendariosList },
    { path: '/categorias', component: CategoriasList },
    { path: '/recursos', component: RecursosList },
    { path: '/reservas', component: ReservasList },
    { path: '/tramos-horarios', component: TramosHorariosList }
]

// Nota: Normalmente después de esto viene un código para inicializar el router,
// ¡seguro que viene en tu próxima captura!