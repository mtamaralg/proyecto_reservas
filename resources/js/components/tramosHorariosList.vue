<template>
    <div class="contenedor-lista">
        
        <div class="cabecera">
            <h2>Listado de Tramos Horarios</h2>
            
            <button @click="irCrearNuevo" class="btn-nuevo">
                + Añadir tramo horario
            </button>
        </div>
        
        <p v-if="cargando" class="mensaje-cargando">Cargando tramos horarios...</p>
        
        <ul v-else class="lista-recursos">
            <li v-for="tramo in tramos" :key="tramo.id" class="elemento-lista">
                
                <span class="nombre-recurso">
                    Día {{ tramo.dia_semana }}: de {{ tramo.hora_inicio }} a {{ tramo.hora_fin }}
                </span>
                
                <div class="controles">
                    <router-link :to="`/tramos-horarios/${tramo.id}/editar`" class="btn-editar">
                        Editar
                    </router-link>
                    
                    <button @click="eliminarTramo(tramo.id)" class="btn-eliminar">
                        Eliminar
                    </button>
                </div>

            </li>
        </ul> 
    </div>
</template>

<script>
export default {
    name: 'tramos',
    
    data() {
        return {
            tramos: [],
            cargando: true
        }
    },
    
    methods: {
        // --- MÉTODO PARA IR AL FORMULARIO DE AÑADIR ---
        irCrearNuevo() {
            this.$router.push('/tramos-horarios/nuevo');
        },

        // --- MÉTODO PARA CARGAR LOS TRAMOS ---
        async cargarTramos(){
            this.cargando = true;
            try {
                const respuesta = await fetch('http://localhost/api/tramos-horarios');
                this.tramos = await respuesta.json();
            } catch(error) {
                console.error('Error cargando tramos horarios: ', error);
            } finally {
                this.cargando = false;
            }
        },

        // --- MÉTODO PARA ELIMINAR UN TRAMO ---
        async eliminarTramo(id) {
            if (!confirm("¿Estás seguro de que quieres eliminar este tramo horario?")) {
                return;
            }

            try {
                const url = `http://localhost/api/tramos-horarios/${id}`;
                const respuesta = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        "Accept": "application/json"
                    }
                });

                if (respuesta.ok) {
                    this.cargarTramos(); 
                } else {
                    alert("Error al intentar eliminar el tramo horario.");
                }
            } catch(error) {
                console.error('Error eliminando tramo horario:', error);
                alert("No se pudo conectar con el servidor.");
            }
        }
    },
    
    mounted(){
        this.cargarTramos();
    }
};
</script>

