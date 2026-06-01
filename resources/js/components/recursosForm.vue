<template>
  <div class="formulario-contenedor">
    <!-- Título dinámico: cambia si estamos editando o creando -->
    <h2 v-if="recursoId">Editar Recurso</h2>
    <h2 v-else>Añadir Nuevo Recurso</h2>

    <!-- Enlace para volver fácilmente a la lista sin recargar la página -->
    <router-link to="/recursos" class="enlace-volver">← Volver a la lista</router-link>

    <!-- @submit.prevent captura el envío y evita el recargo de página -->
    <form @submit.prevent="guardarRecurso" class="mi-formulario">
      
      <!-- Campo Nombre -->
      <div class="campo">
        <label>Nombre del recurso:</label>
        <!-- v-model conecta esto directamente con this.recurso.nombre -->
        <input v-model="recurso.nombre" type="text" required placeholder="Ej: Aula 101, Proyector..." />
      </div>

      <!-- Campo Descripción -->
      <div class="campo">
        <label>Descripción:</label>
        <textarea v-model="recurso.descripcion" rows="4" placeholder="Detalles del recurso..."></textarea>
      </div>

      <!-- Botón dinámico -->
      <button type="submit" class="btn-guardar">
        {{ recursoId ? "Actualizar Recurso" : "Guardar Recurso" }}
      </button>

    </form>

    <!-- Mensaje de feedback para el usuario (se pinta de verde o rojo según el caso) -->
    <p v-if="mensaje" class="mensaje-alerta">
      {{ mensaje }}
    </p>
  </div>
</template>

<script>
export default {
  name: "RecursosForm",
  
  // Recibimos el ID desde el Router si es que venimos a editar
  props: {
    recursoId: Number
  },

  // Nuestro almacén de memoria
  data() {
    return {
      // Molde vacío del recurso. ¡Añade aquí más campos si tu tabla de Laravel los tiene!
      recurso: {
        nombre: "",
        descripcion: "",
        categoria_id: 1
      },
      mensaje: ""
    };
  },

  // Nada más cargar la pantalla, comprobamos si hay que rescatar datos
  async mounted() {
    if (this.recursoId) {
      await this.cargarRecurso();
    }
  },

  methods: {
    // Método para ir a buscar los datos antiguos si estamos editando
    async cargarRecurso() {
      try {
        const respuesta = await fetch(`http://localhost/api/recursos/${this.recursoId}`);
        if (respuesta.ok) {
          // Rellenamos el formulario automáticamente
          this.recurso = await respuesta.json();
        } else {
          this.mensaje = "Error al encontrar el recurso en la base de datos.";
        }
      } catch (error) {
        console.error("Error cargando recurso:", error);
        this.mensaje = "No se pudo conectar con el servidor.";
      }
    },

    // Método principal para enviar los datos a Laravel
    async guardarRecurso() {
      try {
        // ¿Editamos (PUT) o creamos (POST)?
        const metodo = this.recursoId ? "PUT" : "POST";
        console.log(metodo);
        
        // ¿A qué URL lo enviamos?
        const url = this.recursoId
          ? `http://localhost/api/recursos/${this.recursoId}`
          : "http://localhost/api/recursos";
        console.log(url);
        // El cartero hace su trabajo
        const respuesta = await fetch(url, {
          method: metodo,
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
          },
          body: JSON.stringify(this.recurso)
        });
        console.log(respuesta);
        // Comprobamos el semáforo
        if (respuesta.ok) {
          this.mensaje = this.recursoId 
            ? "¡Recurso actualizado con éxito!" 
            : "¡Nuevo recurso guardado perfectamente!";
            
          // Si era uno nuevo, vaciamos las cajas de texto para que pueda seguir creando
          if (!this.recursoId) {
            this.recurso = { nombre: "", descripcion: "" };
          }
        } else {
          this.mensaje = "Ups, hubo un problema al guardar los datos.";
        }
      } catch (error) {
        console.error("Error guardando recurso:", error);
        this.mensaje = "Error de conexión con el servidor.";
      }
    },
    async eliminarRecurso() {
      // 1. Siempre es buena práctica pedir confirmación antes de borrar algo
      if (!confirm("¿Estás seguro de que quieres eliminar este recurso? Esta acción no se puede deshacer.")) {
        return; // Si el usuario cancela, detenemos la función aquí
      }

      try {
        const url = `http://localhost/api/recursos/${this.recursoId}`;
        
        // El cartero envía la petición con el método DELETE
        const respuesta = await fetch(url, {
          method: "DELETE",
          headers: {
            "Accept": "application/json"
          }
        });

        if (respuesta.ok) {
          // Si todo va bien, no nos quedamos en esta pantalla porque el recurso ya no existe.
          // Usamos this.$router.push para mandar al usuario de vuelta a la lista.
          alert("¡Recurso eliminado correctamente!");
          this.$router.push('/recursos');
        } else {
          this.mensaje = "Error al intentar eliminar el recurso.";
        }
      } catch (error) {
        console.error("Error eliminando recurso:", error);
        this.mensaje = "No se pudo conectar con el servidor.";
      }
    }
  },
};
</script>
