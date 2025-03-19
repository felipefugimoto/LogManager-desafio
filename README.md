# 📦 Desafio de Integração Laravel 10 + Vue.js 3 com Mercado Livre

## 📌 Descrição do Desafio

Este projeto tem como objetivo integrar um backend em Laravel 10 com um frontend em Vue.js 3 para gerenciar a publicação de produtos no Mercado Livre. A aplicação permite a autenticação do usuário, o gerenciamento de tokens e a publicação de produtos na plataforma.

## 🛠️ Tecnologias Utilizadas

### Backend
- **Laravel 10** – Framework PHP para a construção da API.
- **MySQL** – Banco de dados para armazenamento de produtos e credenciais.
- **GuzzleHTTP** – Cliente HTTP para requisições à API do Mercado Livre.
- **JWT Auth** – Autenticação segura para os usuários.

  #Gerenciar tokens do Mercado Livre

- **GET /api/listaToken → Lista todos os tokens

- **GET /api/token/{id} → Busca um token específico

- **PUT /api/token/{id} → Atualiza um token

- **DELETE /api/token/{id} → Exclui um token

  
  #Autenticação Mercado Livre

- **GET /api/mercadolivre/auth → Redireciona para login

- **GET /api/mercadolivre/callback → Callback de autenticação


  #Gerenciamento de Produtos

- **POST /api/produtos → Publica um novo produto

- **GET /api/listaprodutos → Lista todos os produtos

- **GET /api/produtos/{item_id} → Cadastra um produto

- **GET /api/produtos/busca/{item_id} → Busca um produto

- **PUT /api/produtos/alterar/{item_id} → Atualiza um produto

- **DELETE /api/produtos/apagar/{item_id} → Exclui um produto

### Frontend
- **Vue.js 3** – Framework JavaScript para a interface do usuário.
- **Vue Router** – Gerenciamento de rotas no frontend.
- **Bootstrap** – Estilização das telas.
- **Axios** – Comunicação com a API.

## 🚀 Funcionalidades Implementadas

✅ Autenticação de usuários (login/logout).  
✅ Gerenciamento de tokens do Mercado Livre.  
✅ Listagem, cadastro e atualização de produtos.  
✅ Publicação de produtos na API do Mercado Livre.  
✅ Interface organizada e responsiva utilizando Bootstrap.

## 📂 Como Executar o Projeto

### 🔧 Backend (Laravel 10)

1. Clone o repositório:
   ```sh
   git clone https://github.com/seu-usuario/seu-repositorio.git
   cd seu-repositorio/backend
