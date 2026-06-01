<template>
  <div class="formulario-contenedor">
    <!-- Título dinámico -->
    <h2 v-if="categoriaId">Editar Categoría</h2>
    <h2 v-else>Añadir Nueva Categoría</h2>

    <!-- Enlace para volver a la lista de categorías -->
    <router-link to="/categorias" class="enlace-volver">← Volver a la lista</router-link>

    <!-- Formulario -->
    <form @submit.prevent="guardarCategoria" class="mi-formulario">
      
      <!-- Campo Nombre -->
      <div class="campo">
        <label>Nombre de la categoría:</label>
        <input v-model="categoria.nombre" type="text" required placeholder="Ej: Material Audiovisual, Espacios..." />
      </div>

      <!-- Campo Descripción -->
      <div class="campo">
        <label>Descripción:</label>
        <textarea v-model="categoria.descripcion" rows="4" placeholder="Detalles de la categoría..."></textarea>
      </div>

      <!-- Botón inteligente -->
      <button type="submit" class="btn-guardar">
        {{ categoriaId ? "Actualizar Categoría" : "Guardar Categoría" }}
      </button>

    </form>

    <!-- Mensaje de feedback -->
    <p v-if="mensaje" class="mensaje-alerta">
      {{ mensaje }}
    </p>
  </div>
</template>

<script>
export default {
  name: "CategoriaForm",
  
  // Recibimos el ID desde el Router si venimos a editar
  props: {
    categoriaId: Number
  },

  // Nuestro almacén de memoria
  data() {
    return {
      // Molde vacío de la categoría
      categoria: {
        nombre: "",
        descripcion: ""
      },
      mensaje: ""
    };
  },

  // Al cargar la pantalla, si hay ID, rescatamos los datos
  async mounted() {
    if (this.categoriaId) {
      await this.cargarCategoria();
    }
  },

  methods: {
    // Buscar datos antiguos
    async cargarCategoria() {
      try {
        const respuesta = await fetch(`http://localhost/api/categorias/${this.categoriaId}`);
        if (respuesta.ok) {
          this.categoria = await respuesta.json();
        } else {
          this.mensaje = "Error al encontrar la categoría en la base de datos.";
        }
      } catch (error) {
        console.error("Error cargando categoría:", error);
        this.mensaje = "No se pudo conectar con el servidor.";
      }
    },

    // Enviar datos (Crear o Actualizar)
    async guardarCategoria() {
      try {
        const metodo = this.categoriaId ? "PUT" : "POST";
        
        const url = this.categoriaId
          ? `http://lochalhost/api/categorias/${this.categoriaId}`
          : "http://localhost/api/categorias";

        const respuesta = await fetch(url, {
          method: metodo,
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
          },
          body: JSON.stringify(this.categoria)
        });

        if (respuesta.ok) {
          this.mensaje = this.categoriaId 
            ? "¡Categoría actualizada con éxito!" 
            : "¡Nueva categoría guardada perfectamente!";
            
          // Si era nueva, vaciamos los campos
          if (!this.categoriaId) {
            this.categoria = { nombre: "", descripcion: "" };
          }
        } else {
          this.mensaje = "Ups, hubo un problema al guardar los datos.";
        }
      } catch (error) {
        console.error("Error guardando categoría:", error);
        this.mensaje = "Error de conexión con el servidor.";
      }
    }
  }
};
</script>