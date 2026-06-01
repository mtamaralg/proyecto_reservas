<template>
  <div class="formulario-contenedor">
    <!-- Título dinámico -->
    <h2 v-if="tramoId">Editar Tramo Horario</h2>
    <h2 v-else>Añadir Nuevo Tramo Horario</h2>

    <!-- Enlace para volver a la lista -->
    <router-link to="/tramos-horarios" class="enlace-volver">← Volver a la lista</router-link>

    <!-- Formulario -->
    <form @submit.prevent="guardarTramo" class="mi-formulario">
      
      <!-- Campo Nombre del Tramo -->
      <div class="campo">
        <label>Nombre / Identificador:</label>
        <input v-model="tramo.nombre" type="text" required placeholder="Ej: Primera hora, Recreo, Tramo 1..." />
      </div>

      <!-- Campo Hora Inicio -->
      <div class="campo">
        <label>Hora de inicio:</label>
        <input v-model="tramo.hora_inicio" type="time" required />
      </div>

      <!-- Campo Hora Fin -->
      <div class="campo">
        <label>Hora de finalización:</label>
        <input v-model="tramo.hora_fin" type="time" required />
      </div>

      <!-- Botón inteligente -->
      <button type="submit" class="btn-guardar">
        {{ tramoId ? "Actualizar Tramo" : "Guardar Tramo" }}
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
  name: "TramosHorariosForm",
  
  // Recibimos el ID desde el Router si venimos a editar
  props: {
    tramoId: Number
  },

  // Nuestro almacén de memoria
  data() {
    return {
      // Molde vacío de un tramo horario
      tramo: {
        nombre: "",
        hora_inicio: "",
        hora_fin: ""
      },
      mensaje: ""
    };
  },

  // Al cargar la pantalla, si hay ID, rescatamos los datos
  async mounted() {
    if (this.tramoId) {
      await this.cargarTramo();
    }
  },

  methods: {
    // Buscar datos del tramo antiguo
    async cargarTramo() {
      try {
        const respuesta = await fetch(`http://127.0.0.1:8000/api/tramos-horarios/${this.tramoId}`);
        if (respuesta.ok) {
          this.tramo = await respuesta.json();
        } else {
          this.mensaje = "Error al encontrar el tramo horario en la base de datos.";
        }
      } catch (error) {
        console.error("Error cargando tramo:", error);
        this.mensaje = "No se pudo conectar con el servidor.";
      }
    },

    // Enviar datos (Crear o Actualizar)
    async guardarTramo() {
      try {
        const metodo = this.tramoId ? "PUT" : "POST";
        
        const url = this.tramoId
          ? `http://127.0.0.1:8000/api/tramos-horarios/${this.tramoId}`
          : "http://127.0.0.1:8000/api/tramos-horarios";

        const respuesta = await fetch(url, {
          method: metodo,
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(this.tramo)
        });

        if (respuesta.ok) {
          this.mensaje = this.tramoId 
            ? "¡Tramo horario actualizado con éxito!" 
            : "¡Nuevo tramo horario guardado perfectamente!";
            
          // Si era nuevo, vaciamos los campos
          if (!this.tramoId) {
            this.tramo = { nombre: "", hora_inicio: "", hora_fin: "" };
          }
        } else {
          this.mensaje = "Ups, hubo un problema al guardar los datos.";
        }
      } catch (error) {
        console.error("Error guardando tramo horario:", error);
        this.mensaje = "Error de conexión con el servidor.";
      }
    }
  }
};
</script>