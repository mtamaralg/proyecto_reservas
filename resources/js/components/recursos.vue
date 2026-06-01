<template>
    <div class="contenedor-lista">
        
        <div class="cabecera">
            <h2>Listado de Recursos</h2>
            
            <button @click="irCrearNuevo" class="btn-nuevo">
                + Añadir recurso
            </button>
        </div>
        
        <p v-if="cargando" class="mensaje-cargando">Cargando recursos...</p>
        
        <ul v-else class="lista-recursos">
            <li v-for="recurso in recursos" :key="recurso.id" class="elemento-lista">
                
                <span class="nombre-recurso">{{ recurso.nombre }}</span>
                
                <div class="controles">
                    <router-link :to="`/recursos/${recurso.id}/editar`" class="btn-editar">
                        Editar
                    </router-link>
                    
                    <button @click="eliminarRecurso(recurso.id)" class="btn-eliminar">
                        Eliminar
                    </button>
                </div>

            </li>
        </ul> 
    </div>
</template>

<script>
export default {
    name: 'recursos',
    
    data() {
        return {
            recursos: [],
            cargando: true
        }
    },
    
    methods: {
        // --- MÉTODO PARA IR AL FORMULARIO DE AÑADIR ---
        irCrearNuevo() {
            this.$router.push('/recursos/nuevo');
        },

        // --- MÉTODO PARA CARGAR LOS RECURSOS ---
        async cargarRecursos(){
            this.cargando = true;
            try {
                const respuesta = await fetch('http://localhost/api/recursos');
                this.recursos = await respuesta.json();
            } catch(error) {
                console.error('Error cargando recursos: ', error);
            } finally {
                this.cargando = false;
            }
        },

        // --- MÉTODO PARA ELIMINAR UN RECURSO ---
        async eliminarRecurso(id) {
            if (!confirm("¿Estás seguro de que quieres eliminar este recurso?")) {
                return;
            }

            try {
                const url = `http://localhost/api/recursos/${id}`;
                const respuesta = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        "Accept": "application/json"
                    }
                });

                if (respuesta.ok) {
                    // Si se elimina correctamente, volvemos a cargar la lista
                    this.cargarRecursos(); 
                } else {
                    alert("Error al intentar eliminar el recurso.");
                }
            } catch(error) {
                console.error('Error eliminando recurso:', error);
                alert("No se pudo conectar con el servidor.");
            }
        }
    },
    
    mounted(){
        this.cargarRecursos();
    }
};
</script>
