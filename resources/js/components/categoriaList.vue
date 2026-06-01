<template>
    <div class="contenedor-lista">
        
        <div class="cabecera">
            <h2>Listado de Categorías</h2>
            
            <button @click="irCrearNuevo" class="btn-nuevo">
                + Añadir categoría
            </button>
        </div>
        
        <p v-if="cargando" class="mensaje-cargando">Cargando categorías...</p>
        
        <ul v-else class="lista-recursos">
            <li v-for="categoria in categorias" :key="categoria.id" class="elemento-lista">
                
                <span class="nombre-recurso">{{ categoria.nombre }}</span>
                
                <div class="controles">
                    <router-link :to="`/categorias/${categoria.id}/editar`" class="btn-editar">
                        Editar
                    </router-link>
                    
                    <button @click="eliminarCategoria(categoria.id)" class="btn-eliminar">
                        Eliminar
                    </button>
                </div>

            </li>
        </ul> 
    </div>
</template>

<script>
export default {
    name: 'categorias',
    
    data() {
        return {
            categorias: [],
            cargando: true
        }
    },
    
    methods: {
        // --- MÉTODO PARA IR AL FORMULARIO DE AÑADIR ---
        irCrearNuevo() {
            this.$router.push('/categorias/nuevo');
        },

        // --- MÉTODO PARA CARGAR LAS CATEGORÍAS ---
        async cargarCategorias(){
            this.cargando = true;
            try {
                const respuesta = await fetch('http://localhost/api/categorias');
                this.categorias = await respuesta.json();
            } catch(error) {
                console.error('Error cargando categorías: ', error);
            } finally {
                this.cargando = false;
            }
        },

        // --- MÉTODO PARA ELIMINAR UNA CATEGORÍA ---
        async eliminarCategoria(id) {
            if (!confirm("¿Estás seguro de que quieres eliminar esta categoría?")) {
                return;
            }

            try {
                const url = `http://localhost/api/categorias/${id}`;
                const respuesta = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        "Accept": "application/json"
                    }
                });

                if (respuesta.ok) {
                    // Recargamos la lista si se borra correctamente
                    this.cargarCategorias(); 
                } else {
                    alert("Error al intentar eliminar la categoría.");
                }
            } catch(error) {
                console.error('Error eliminando categoría:', error);
                alert("No se pudo conectar con el servidor.");
            }
        }
    },
    
    mounted(){
        this.cargarCategorias();
    }
};
</script>
