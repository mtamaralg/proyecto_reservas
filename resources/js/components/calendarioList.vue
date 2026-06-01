<template>
    <div class="contenedor-lista">
        
        <div class="cabecera">
            <h2>Listado de Calendarios</h2>
            
            <button @click="irCrearNuevo" class="btn-nuevo">
                + Añadir calendario
            </button>
        </div>
        
        <p v-if="cargando" class="mensaje-cargando">Cargando calendarios...</p>
        
        <ul v-else class="lista-recursos">
            <li v-for="calendario in calendarios" :key="calendario.id" class="elemento-lista">
                
                <span class="nombre-recurso">{{ calendario.fecha }}</span>
                
                <div class="controles">
                    <router-link :to="`/calendarios/${calendario.id}/editar`" class="btn-editar">
                        Editar
                    </router-link>
                    
                    <button @click="eliminarCalendario(calendario.id)" class="btn-eliminar">
                        Eliminar
                    </button>
                </div>

            </li>
        </ul> 
    </div>
</template>

<script>
export default {
    name: 'calendarios',
    
    data() {
        return {
            calendarios: [],
            cargando: true
        }
    },
    
    methods: {
        // --- MÉTODO PARA IR AL FORMULARIO DE AÑADIR ---
        irCrearNuevo() {
            this.$router.push('/calendarios/nuevo');
        },

        // --- MÉTODO PARA CARGAR LOS CALENDARIOS ---
        async cargarCalendarios(){
            this.cargando = true;
            try {
                const respuesta = await fetch('http://localhost/api/calendarios');
                this.calendarios = await respuesta.json();
            } catch(error) {
                console.error('Error cargando calendarios: ', error);
            } finally {
                this.cargando = false;
            }
        },

        // --- MÉTODO PARA ELIMINAR UN CALENDARIO ---
        async eliminarCalendario(id) {
            if (!confirm("¿Estás seguro de que quieres eliminar este calendario?")) {
                return;
            }

            try {
                const url = `http://localhost/api/calendarios/${id}`;
                const respuesta = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        "Accept": "application/json"
                    }
                });

                if (respuesta.ok) {
                    this.cargarCalendarios(); 
                } else {
                    alert("Error al intentar eliminar el calendario.");
                }
            } catch(error) {
                console.error('Error eliminando calendario:', error);
                alert("No se pudo conectar con el servidor.");
            }
        }
    },
    
    mounted(){
        this.cargarCalendarios();
    }
};
</script>