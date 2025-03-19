<template>
  <div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="card text-center p-4 shadow-lg">
      <h1 class="h4 fw-bold mb-3">Processando Autenticação...</h1>
      <div v-if="loading" class="text-secondary">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Carregando...</span>
        </div>
        <p>Aguarde enquanto validamos seu acesso...</p>
      </div>
      <p v-if="error" class="text-danger fw-bold">{{ error }}</p>
      <p v-if="success" class="text-success fw-bold">Autenticação realizada com sucesso!</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";

const route = useRoute();
const router = useRouter();
const loading = ref(true);
const error = ref(null);
const success = ref(false);

onMounted(async () => {
  const code = route.query.code;
  if (!code) {
    error.value = "Código de autorização não encontrado.";
    loading.value = false;
    return;
  }

  try {
    await axios.get(`http://seu-backend.com/api/mercadolivre/callback?code=${code}`);
    success.value = true;
    setTimeout(() => router.push("/dashboard"), 2000);
  } catch {
    error.value = "Falha ao obter token. Tente novamente.";
  } finally {
    loading.value = false;
  }
});
</script>

<style scoped>
.card {
  max-width: 400px;
}
</style>
