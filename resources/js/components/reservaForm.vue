<template>
  <div class="formulario-contenedor">
    <!-- Título dinámico -->
    <h2 v-if="reservaId">Editar Reserva</h2>
    <h2 v-else>Crear Nueva Reserva</h2>

    <!-- Enlace para volver a la lista -->
    <router-link to="/reservas" class="enlace-volver">← Volver a la lista</router-link>

    <!-- Formulario -->
    <form @submit.prevent="guardarReserva" class="mi-formulario">
      
      <!-- Campo ID del Recurso (Más adelante aprenderás a cambiar esto por un desplegable <select>) -->
      <div class="campo">
        <label>ID del Recurso a reservar:</label>
        <input v-model="reserva.recurso_id" type="number" required placeholder="Ej: 1, 2, 3..." />
      </div>

      <!-- Campo Fecha -->
      <div class="campo">
        <label>Fecha de la reserva:</label>
        <input v-model="reserva.fecha" type="date" required />
      </div>

      <!-- Campo Hora Inicio -->
      <div class="campo">
        <label>Hora de inicio:</label>
        <input v-model="reserva.hora_inicio" type="time" required />
      </div>

      <!-- Campo Hora Fin -->
      <div class="campo">
        <label>Hora de finalización:</label>
        <input v-model="reserva.hora_fin" type="time" required />
      </div>

      <!-- Campo Motivo / Descripción -->
      <div class="campo">
        <label>Motivo de la reserva:</label>
        <textarea v-model="reserva.motivo" rows="3" placeholder="Ej: Clase de repaso, Reunión de departamento..."></textarea>
      </div>

      <!-- Botón inteligente -->
      <button type="submit" class="btn-guardar">
        {{ reservaId ? "Actualizar Reserva" : "Confirmar Reserva" }}
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
  name: "ReservaForm",
  
  // Recibimos el ID desde el Router si venimos a editar
  props: {
    reservaId: Number
  },

  // Nuestro almacén de memoria
  data() {
    return {
      reserva: {
        recurso_id: "",
        usuario_id: "", 
        tramo_horario_id: "", 
        fecha: "",
        hora_inicio: "",
        hora_fin: "",
        motivo: ""
      },
      mensaje: ""
    };
},

  // Al cargar la pantalla, si hay ID, rescatamos los datos
  async mounted() {
    if (this.reservaId) {
      await this.cargarReserva();
    }
  },

  methods: {
    // Buscar datos de la reserva antigua
    async cargarReserva() {
      try {
        const respuesta = await fetch(`http://localhost/api/reservas/${this.reservaId}`);
        if (respuesta.ok) {
          this.reserva = await respuesta.json();
        } else {
          this.mensaje = "Error al encontrar la reserva en la base de datos.";
        }
      } catch (error) {
        console.error("Error cargando reserva:", error);
        this.mensaje = "No se pudo conectar con el servidor.";
      }
    },

    // Enviar datos (Crear o Actualizar)
    async guardarReserva() {
      try {
        const metodo = this.reservaId ? "PUT" : "POST";
        
        const url = this.reservaId
          ? `http://localhost/api/reservas/${this.reservaId}`
          : "http://localhost/api/reservas";

        const respuesta = await fetch(url, {
          method: metodo,
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
          },
          body: JSON.stringify(this.reserva)
        });

        if (respuesta.ok) {
          this.mensaje = this.reservaId 
            ? "¡Reserva modificada con éxito!" 
            : "¡Reserva confirmada perfectamente!";
            
          // Si era nueva, vaciamos los campos para otra posible reserva
          if (!this.reservaId) {
            this.reserva = { recurso_id: "", fecha: "", hora_inicio: "", hora_fin: "", motivo: "" };
          }
        } else {
          this.mensaje = "Ups, hubo un problema al guardar la reserva.";
        }
      } catch (error) {
        console.error("Error guardando reserva:", error);
        this.mensaje = "Error de conexión con el servidor.";
      }
    }
  }
};
</script>