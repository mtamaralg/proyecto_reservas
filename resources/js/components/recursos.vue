<template>
    <div>
        <p v-if="cargando">Cargando recursos...</p>
        <ul v-else>
            <li v-for="recurso in recursos" :key="recurso.id">
                {{recurso.nombre}}
            </li>
        </ul> 
        <a href="recursosForm" >Añadir nuevo recurso </a>           
    </div>
</template>

<script>
export default {
    name: 'recursos',
    data() {
        return {
            nuevoRecurso: '',
            recursos: [],
            cargando: true
        }
    },
    methods: {
        async cargarRecursos(){
            try{
                const respuesta = await fetch('http://localhost/api/recursos');
                this.recursos = await respuesta.json();
            }catch(error){
                console.error('Error cargando recursos: ', error);
            }finally{
                this.cargando = false;
            }
        },
        crearRecurso(){
            if(this.nuevoRecurso === '') return;
            this.recursos.push({ 
                id: Date.now(),
                nombre: this.nuevoRecurso,
            });
            this.nuevoRecurso = '';
        }
    },
    mounted(){
        this.cargarRecursos();
    }
};
</script>