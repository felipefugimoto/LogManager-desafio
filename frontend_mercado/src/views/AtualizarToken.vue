<template>
  <div class="container d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div class="card shadow p-4 text-center" style="max-width: 500px; width: 100%;">
      <h1 class="h4 fw-bold mb-3">Atualizar Token de Acesso</h1>
      <button @click="atualizarToken" class="btn btn-primary w-100">Atualizar Token</button>
      
      <div v-if="mensagem" class="alert mt-3" :class="{'alert-success': success, 'alert-danger': !success}">
        {{ mensagem }}
      </div>

      <div v-if="token" class="mt-4 text-start bg-light p-3 rounded">
        <p><strong>Access Token:</strong> {{ token.access_token }}</p>
        <p><strong>Refresh Token:</strong> {{ token.refresh_token }}</p>
        <p><strong>Expira em:</strong> {{ token.expires_at }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      token: null,
      mensagem: "",
      success: false
    };
  },
  methods: {
    async atualizarToken() {
      try {
        const response = await axios.get("http://localhost:8000/api/refrsh-token");
        this.token = response.data.token;
        this.mensagem = response.data.message;
        this.success = true;
      } catch (error) {
        this.mensagem = "Erro ao atualizar token";
        this.success = false;
      }
    }
  }
};
</script>

<style scoped>
.card {
  width: 100%;
  max-width: 500px;
}
</style>
