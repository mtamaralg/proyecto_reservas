<template>
    <div>
        <h1>Mi Sistema de Reservas</h1>
        
        <!-- Nuestro menú de navegación usando router-link -->
        <nav style="margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #ccc;">
            <router-link style="margin-right: 15px;" to="/recursos">Recursos</router-link>
            <router-link style="margin-right: 15px;" to="/categorias">Categorías</router-link>
            <router-link style="margin-right: 15px;" to="/calendarios">Calendarios</router-link>
            <router-link style="margin-right: 15px;" to="/reservas">Reservas</router-link>
            <router-link to="/tramos-horarios">Tramos Horarios</router-link>
        </nav>

        <!-- Aquí es donde Vue inyectará las listas mágicamente -->
        <router-view />
    </div>
</template>

<script>
export default {
    name: 'App'
}
</script>