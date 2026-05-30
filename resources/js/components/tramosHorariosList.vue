<template>
    <div>
        <p v-if="cargando">Cargando tramos horarios...</p>
        <ul v-else>
            <li v-for="tramo in tramos" :key="tramo.id">
                Día {{tramo.dia_semana}}: de {{tramo.hora_inicio}} a {{tramo.hora_fin}}
            </li>
        </ul>            
    </div>
</template>

<script>
export default {
    name: 'tramos',
    data() {
        return {
            nuevoTramo: '',
            tramos: [],
            cargando: true
        }
    },
    methods: {
        async cargarTramos(){
            try{
                const respuesta = await fetch('http://localhost/api/tramos-horarios');
                this.tramos = await respuesta.json();
            }catch(error){
                console.error('Error cargando tramos horarios: ', error);
            }finally{
                this.cargando = false;
            }
        },
        crearTramo(){
            if(this.nuevoTramo === '') return;
            this.tramos.push({ 
                id: Date.now(),
                // Metemos un par de datos de relleno para la simulación visual
                dia_semana: 1,
                hora_inicio: this.nuevoTramo,
                hora_fin: '00:00:00'
            });
            this.nuevoTramo = '';
        }
    },
    mounted(){
        this.cargarTramos();
    }
};
</script>