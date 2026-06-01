<template>
  <div class="formulario-contenedor">
    <!-- Título dinámico -->
    <h2 v-if="calendarioId">Editar Calendario</h2>
    <h2 v-else>Añadir Nuevo Calendario</h2>

    <!-- Enlace para volver a la lista de calendarios -->
    <router-link to="/calendarios" class="enlace-volver">← Volver a la lista</router-link>

    <!-- Formulario con prevent para evitar recargas -->
    <form @submit.prevent="guardarCalendario" class="mi-formulario">
      
      <!-- Campo Nombre del calendario -->
      <div class="campo">
        <label>Nombre del calendario:</label>
        <input v-model="calendario.nombre" type="text" required placeholder="Ej: Calendario Curso 2024/2025" />
      </div>

      <!-- Campo Fecha de Inicio -->
      <div class="campo">
        <label>Fecha de inicio:</label>
        <input v-model="calendario.fecha_inicio" type="date" required />
      </div>

      <!-- Campo Fecha de Fin -->
      <div class="campo">
        <label>Fecha de fin:</label>
        <input v-model="calendario.fecha_fin" type="date" required />
      </div>

      <!-- Botón inteligente (Guardar vs Actualizar) -->
      <button type="submit" class="btn-guardar">
        {{ calendarioId ? "Actualizar Calendario" : "Guardar Calendario" }}
      </button>

    </form>

    <!-- Párrafo para mostrar mensajes de éxito o error -->
    <p v-if="mensaje" class="mensaje-alerta">
      {{ mensaje }}
    </p>
  </div>
</template>

<script>
export default {
  name: "CalendarioForm",
  
  // Recibimos el ID si estamos en modo edición
  props: {
    calendarioId: Number
  },

  // Almacén de memoria reactivo
  data() {
    return {
      // Molde vacío adaptado a un "Calendario"
      calendario: {
        nombre: "",
        fecha_inicio: "",
        fecha_fin: ""
      },
      mensaje: ""
    };
  },

  // Hook que se ejecuta al cargar la pantalla
  async mounted() {
    if (this.calendarioId) {
      await this.cargarCalendario();
    }
  },

  methods: {
    // Pide a Laravel los datos de este calendario específico
    async cargarCalendario() {
      try {
        const respuesta = await fetch(`http://127.0.0.1:8000/api/calendarios/${this.calendarioId}`);
        if (respuesta.ok) {
          this.calendario = await respuesta.json();
        } else {
          this.mensaje = "Error al encontrar el calendario.";
        }
      } catch (error) {
        console.error("Error cargando calendario:", error);
        this.mensaje = "No se pudo conectar con el servidor.";
      }
    },

    // Envía los datos a Laravel (POST o PUT)
    async guardarCalendario() {
      try {
        const metodo = this.calendarioId ? "PUT" : "POST";
        
        const url = this.calendarioId
          ? `http://127.0.0.1:8000/api/calendarios/${this.calendarioId}`
          : "http://127.0.0.1:8000/api/calendarios";

        const respuesta = await fetch(url, {
          method: metodo,
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(this.calendario)
        });

        if (respuesta.ok) {
          this.mensaje = this.calendarioId 
            ? "¡Calendario actualizado con éxito!" 
            : "¡Nuevo calendario guardado perfectamente!";
            
          // Vaciamos si es creación nueva
          if (!this.calendarioId) {
            this.calendario = { nombre: "", fecha_inicio: "", fecha_fin: "" };
          }
        } else {
          this.mensaje = "Ups, hubo un problema al guardar los datos.";
        }
      } catch (error) {
        console.error("Error guardando calendario:", error);
        this.mensaje = "Error de conexión con el servidor.";
      }
    }
  }
};
</script>