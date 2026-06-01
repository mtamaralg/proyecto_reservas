<template>
    <div class="contenedor-lista">
        
        <div class="cabecera">
            <h2>Listado de Reservas</h2>
            
            <button @click="irCrearNuevo" class="btn-nuevo">
                + Añadir reserva
            </button>
        </div>
        
        <p v-if="cargando" class="mensaje-cargando">Cargando reservas...</p>
        
        <ul v-else class="lista-recursos">
            <li v-for="reserva in reservas" :key="reserva.id" class="elemento-lista">
                
                <span class="nombre-recurso">Reserva #{{ reserva.id }}</span>
                
                <div class="controles">
                    <router-link :to="`/reservas/${reserva.id}/editar`" class="btn-editar">
                        Editar
                    </router-link>
                    
                    <button @click="eliminarReserva(reserva.id)" class="btn-eliminar">
                        Eliminar
                    </button>
                </div>

            </li>
        </ul> 
    </div>
</template>

<script>
export default {
    name: 'reservas',
    
    data() {
        return {
            reservas: [],
            cargando: true
        }
    },
    
    methods: {
        // --- MÉTODO PARA IR AL FORMULARIO DE AÑADIR ---
        irCrearNuevo() {
            // Recuerda que en el router.js usamos "nueva" en femenino para las reservas
            this.$router.push('/reservas/nueva');
        },

        // --- MÉTODO PARA CARGAR LAS RESERVAS ---
        async cargarReservas(){
            this.cargando = true;
            try {
                const respuesta = await fetch('http://localhost/api/reservas');
                this.reservas = await respuesta.json();
            } catch(error) {
                console.error('Error cargando reservas: ', error);
            } finally {
                this.cargando = false;
            }
        },

        // --- MÉTODO PARA ELIMINAR UNA RESERVA ---
        async eliminarReserva(id) {
            if (!confirm("¿Estás seguro de que quieres cancelar y eliminar esta reserva?")) {
                return;
            }

            try {
                const url = `http://localhost/api/reservas/${id}`;
                const respuesta = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        "Accept": "application/json"
                    }
                });

                if (respuesta.ok) {
                    this.cargarReservas(); 
                } else {
                    alert("Error al intentar eliminar la reserva.");
                }
            } catch(error) {
                console.error('Error eliminando reserva:', error);
                alert("No se pudo conectar con el servidor.");
            }
        }
    },
    
    mounted(){
        this.cargarReservas();
    }
};
</script>