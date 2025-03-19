<template>
  <div class="container py-5">

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="bg-white p-8 rounded-lg shadow-lg text-center max-w-md w-full">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Autenticação Mercado Livre</h1>
        <p class="mb-6 text-gray-600">
          Clique no botão abaixo para autenticar-se com o Mercado Livre.
        </p>
        <div class="flex justify-center">
          <button
            @click="autenticar"
            class="bg-gradient-to-r from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700 text-black font-bold py-3 px-6 rounded-lg transition-all shadow-md hover:shadow-lg"
          >
            🔑 Autenticar com Mercado Livre
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const autenticar = () => {
  const clientId = "3743748400398289";
  const redirectUri = encodeURIComponent("http://seu-backend.com/api/mercadolivre/callback");
  window.location.href = `https://auth.mercadolivre.com.br/authorization?response_type=code&client_id=${clientId}&redirect_uri=${redirectUri}`;
};
</script>
