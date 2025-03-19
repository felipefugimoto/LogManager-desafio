<template>
  <div class="home-container">
    <header>
      <h1>Bem-vindo ao Painel Mercado Livre</h1>
      <p>Gerencie seus produtos e tokens de forma fácil e eficiente</p>
    </header>

    <div class="buttons">
      <router-link to="/tokenManager" class="btn">Autenticar</router-link>
      <router-link to="/produto" class="btn">Gerenciar Produtos</router-link>
      <router-link to="/mercadoLivre" class="btn">Mercado Livre</router-link>
      <router-link to="/tokenManager" class="btn">Token Manager</router-link>
      <router-link to="/callback" class="btn">Callback</router-link>
      <router-link to="/atualizarToken" class="btn">Atualizar Token</router-link>
    </div>
  </div>
</template>

<style scoped>
.home-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  text-align: center;
  background: linear-gradient(to right, #4CAF50, #2E7D32);
  color: white;
  padding: 20px;
}

header h1 {
  font-size: 2.5rem;
  margin-bottom: 10px;
}

header p {
  font-size: 1.2rem;
  margin-bottom: 30px;
}

.buttons {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 15px;
  max-width: 600px;
}

.btn {
  background: white;
  color: #2E7D32;
  padding: 12px 24px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.3s ease-in-out;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
}

.btn:hover {
  background: #C8E6C9;
  transform: scale(1.05);
}
</style>
