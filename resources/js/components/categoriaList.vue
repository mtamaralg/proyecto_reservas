<template>
    <div>
        <p v-if="cargando">Cargando categorías...</p>
        <ul v-else>
            <li v-for="categoria in categorias" :key="categoria.id">
                {{categoria.nombre}}
            </li>
        </ul>            
    </div>
</template>

<script>
export default {
    name: 'categorias',
    data() {
        return {
            nuevaCategoria: '',
            categorias: [],
            cargando: true
        }
    },
    methods: {
        async cargarCategorias(){
            try{
                const respuesta = await fetch('http://localhost/api/categorias');
                this.categorias = await respuesta.json();
            }catch(error){
                console.error('Error cargando categorías: ', error);
            }finally{
                this.cargando = false;
            }
        },
        crearCategoria(){
            if(this.nuevaCategoria === '') return;
            this.categorias.push({ 
                id: Date.now(),
                nombre: this.nuevaCategoria,
            });
            this.nuevaCategoria = '';
        }
    },
    mounted(){
        this.cargarCategorias();
    }
};
</script>