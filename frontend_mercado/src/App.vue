<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <nav>
    <RouterLink to="/">Home</RouterLink>
    <RouterLink to="/produto">Produto</RouterLink>
    <RouterLink to="/mercadoLivre">Mercado Livre</RouterLink>
    <RouterLink to="/tokenManager">Autenticar</RouterLink>
    <RouterLink to="/callback">Callback</RouterLink>
    <RouterLink to="/atualizarToken">Atualizar Token</RouterLink>
  </nav>

  <main>
    <RouterView />
  </main>
</template>

<style scoped>
nav {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background: #0077b6;
  color: white;
  text-align: center;
  padding: 1rem 0;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  z-index: 1000;
}

nav a {
  color: white;
  text-decoration: none;
  padding: 0.75rem 1.5rem;
  display: inline-block;
  font-weight: bold;
  transition: 0.3s;
}

nav a:hover {
  background: rgba(255, 255, 255, 0.2);
  border-radius: 5px;
}

nav a.router-link-exact-active {
  background: rgba(255, 255, 255, 0.3);
  border-radius: 5px;
}

main {
  padding-top: 60px; /* Para evitar sobreposição do conteúdo */
}
</style>
