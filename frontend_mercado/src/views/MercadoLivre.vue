<template>
  <div class="auth-container">
    <h1 class="title">Autenticação Mercado Livre</h1>
    <p class="description">Clique no botão abaixo para autenticar com o Mercado Livre.</p>
    <button @click="authenticate" class="auth-button">Autenticar</button>
  </div>
</template>

<script setup>
const authenticate = () => {
  window.location.href = "https://www.logmanager.com.br/";
};
</script>

<style scoped>
.auth-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  background: linear-gradient(135deg, #ffffff, #f4f4f4);
  text-align: center;
  padding: 20px;
}

.title {
  font-size: 26px;
  font-weight: bold;
  color: #333;
  margin-bottom: 10px;
}

.description {
  font-size: 18px;
  color: #555;
  margin-bottom: 20px;
}

.auth-button {
  background-color: #ffcc00;
  color: #000;
  font-size: 18px;
  padding: 12px 24px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: transform 0.2s, background 0.3s;
  font-weight: bold;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.auth-button:hover {
  background-color: #e6b800;
  transform: scale(1.05);
}
</style>
