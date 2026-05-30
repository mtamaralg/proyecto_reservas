<template>
    <div>
        <p v-if="cargando">Cargando reservas...</p>
        <ul v-else>
            <li v-for="reserva in reservas" :key="reserva.id">
                Reserva #{{reserva.id}}
            </li>
        </ul>            
    </div>
</template>

<script>
export default {
    name: 'reservas',
    data() {
        return {
            nuevaReserva: '',
            reservas: [],
            cargando: true
        }
    },
    methods: {
        async cargarReservas(){
            try{
                const respuesta = await fetch('http://localhost/api/reservas');
                this.reservas = await respuesta.json();
            }catch(error){
                console.error('Error cargando reservas: ', error);
            }finally{
                this.cargando = false;
            }
        },
        crearReserva(){
            if(this.nuevaReserva === '') return;
            this.reservas.push({ 
                id: Date.now(),
                // Aquí guardamos el dato temporalmente en memoria
                detalle: this.nuevaReserva 
            });
            this.nuevaReserva = '';
        }
    },
    mounted(){
        this.cargarReservas();
    }
};
</script>