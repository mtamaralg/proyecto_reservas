<template>
    <div>
        <p v-if="cargando">Cargando calendarios...</p>
        <ul v-else>
            <li v-for="calendario in calendarios" :key="calendario.id">
                {{calendario.fecha}}
            </li>
        </ul>            
    </div>
</template>

<script>
export default {
    name: 'calendarios',
    data() {
        return {
            nuevoCalendario: '', 
            calendarios: [],
            cargando: true
        }
    },
    methods: {
        async cargarCalendarios(){
            try{
                const respuesta = await fetch('http://localhost/api/calendarios');
                this.calendarios = await respuesta.json();
            }catch(error){
                console.error('Error cargando calendarios: ', error);
            }finally{
                this.cargando = false;
            }
        },
        crearCalendario(){
            if(this.nuevoCalendario === '') return;
            this.calendarios.push({ 
                id: Date.now(),
                fecha: this.nuevoCalendario, // Aquí también usamos fecha
            });
            this.nuevoCalendario = '';
        }
    },
    mounted(){
        this.cargarCalendarios();
    }
};
</script>