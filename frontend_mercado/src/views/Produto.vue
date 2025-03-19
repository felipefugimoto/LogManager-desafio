<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const apiUrl = "http://localhost:8000/api"; // Ajuste conforme necessário
const produtos = ref([]);
const produtoEditado = ref(null);
const newProductId = ref("");
const loading = ref(false);
const mensagem = ref({ tipo: "", texto: "" });

const exibirMensagem = (tipo, texto) => {
  mensagem.value = { tipo, texto };
  setTimeout(() => {
    mensagem.value = { tipo: "", texto: "" };
  }, 3000);
};

const fetchProdutos = async () => {
  try {
    const response = await axios.get(`${apiUrl}/listaprodutos`);
    produtos.value = response.data;
  } catch (error) {
    exibirMensagem("danger", "Erro ao carregar produtos.");
  }
};

const buscarProduto = async () => {
  if (!newProductId.value) {
    exibirMensagem("warning", "Informe o ID do produto.");
    return;
  }
  try {
    const response = await axios.get(`${apiUrl}/produtos/${newProductId.value}`);
    produtoEditado.value = response.data.produto;
    exibirMensagem("success", "Produto encontrado e cadastrado!");
    fetchProdutos();
  } catch (error) {
    exibirMensagem("danger", "Produto não encontrado.");
  }
};

const atualizarProduto = async () => {
  if (!produtoEditado.value) return;
  try {
    await axios.put(`${apiUrl}/produtos/alterar/${produtoEditado.value.id}`, produtoEditado.value);
    exibirMensagem("success", "Produto atualizado!");
    fetchProdutos();
    produtoEditado.value = null;
  } catch (error) {
    exibirMensagem("danger", "Erro ao atualizar produto.");
  }
};

const deletarProduto = async (id) => {
  try {
    await axios.delete(`${apiUrl}/produtos/apagar/${id}`);
    exibirMensagem("success", "Produto deletado!");
    fetchProdutos();
  } catch (error) {
    exibirMensagem("danger", "Erro ao deletar produto.");
  }
};

onMounted(fetchProdutos);
</script>

<template>
  <div class="container-md py-5">
    <h1 class="text-center mb-4">Gerenciamento de Produtos</h1>
    <div v-if="mensagem.texto" :class="`alert alert-${mensagem.tipo}`" role="alert">
      {{ mensagem.texto }}
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <h2 class="h5">Buscar Produto</h2>
        <div class="input-group">
          <input v-model="newProductId" class="form-control" placeholder="ID do Produto" />
          <button @click="buscarProduto" class="btn btn-primary">Buscar e Cadastrar</button>
        </div>
      </div>
    </div>

    <div v-if="produtoEditado" class="card mb-4">
      <div class="card-body">
        <h3 class="h5">Editar Produto</h3>
        <input v-model="produtoEditado.titulo" class="form-control mb-2" placeholder="Título" />
        <input v-model="produtoEditado.categoria" class="form-control mb-2" placeholder="Categoria" />
        <input v-model="produtoEditado.preco" class="form-control mb-2" placeholder="Preço" type="number" />
        <input v-model="produtoEditado.estoque" class="form-control mb-2" placeholder="Estoque" type="number" />
        <button @click="atualizarProduto" class="btn btn-success">Salvar Alterações</button>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <h2 class="h5">Lista de Produtos</h2>
        <table class="table">
          <thead>
            <tr>
              <th>Título</th>
              <th>Categoria</th>
              <th>Preço</th>
              <th>Estoque</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="produto in produtos" :key="produto.id">
              <td>{{ produto.titulo }}</td>
              <td>{{ produto.categoria }}</td>
              <td>R$ {{ produto.preco }}</td>
              <td>{{ produto.estoque }}</td>
              <td>
                <button @click="produtoEditado = { ...produto }" class="btn btn-warning btn-sm">Editar</button>
                <button @click="deletarProduto(produto.id)" class="btn btn-danger btn-sm ms-2">Excluir</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  max-width: 800px;
}
</style>
