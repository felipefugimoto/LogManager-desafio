# 📦 Desafio de Integração Laravel 10 + Vue.js 3 com Mercado Livre

## 📌 Descrição do Desafio

Este projeto tem como objetivo integrar um backend em Laravel 10 com um frontend em Vue.js 3 para gerenciar a publicação de produtos no Mercado Livre. A aplicação permite a autenticação do usuário, o gerenciamento de tokens e a publicação de produtos na plataforma.

## 🛠️ Tecnologias Utilizadas

### Backend
- **Laravel 10** – Framework PHP para a construção da API.
- **MySQL** – Banco de dados para armazenamento de produtos e credenciais.
- **GuzzleHTTP** – Cliente HTTP para requisições à API do Mercado Livre.
- **JWT Auth** – Autenticação segura para os usuários.

  ##Gerenciar tokens do Mercado Livre

- **GET /api/listaToken → Lista todos os tokens

- **GET /api/token/{id} → Busca um token específico

- **PUT /api/token/{id} → Atualiza um token

- **DELETE /api/token/{id} → Exclui um token

  
  ##Autenticação Mercado Livre

- **GET /api/mercadolivre/auth → Redireciona para login

- **GET /api/mercadolivre/callback → Callback de autenticação


  ##Gerenciamento de Produtos

- **POST /api/produtos → Publica um novo produto

- **GET /api/listaprodutos → Lista todos os produtos

- **GET /api/produtos/{item_id} → Cadastra um produto

- **GET /api/produtos/busca/{item_id} → Busca um produto

- **PUT /api/produtos/alterar/{item_id} → Atualiza um produto

- **DELETE /api/produtos/apagar/{item_id} → Exclui um produto

##Tabela produtos
Schema::create('produtos', function (Blueprint $table) {
    $table->id();
    $table->string('titulo');
    $table->string('categoria');
    $table->decimal('preco', 10, 2);
    $table->integer('estoque');
    $table->timestamps();
});

##Tabela tokens

Schema::create('tokens', function (Blueprint $table) {
    $table->id();
    $table->string('access_token')->unique();
    $table->string('refresh_token')->nullable();
    $table->timestamp('expires_at')->nullable();
    $table->timestamps();
});


##Executando o Seeder
Para popular a tabela tokens com um token inicial, foi criado o TokenSeeder:

DB::table('tokens')->insert([
    'access_token' => 'APP_USR-3743748400398289-031908-f3ba763a2925a204e168c9b45c1f79e2-321115696',
    'refresh_token' => 'TG-67daa1da9a882000011f9a33-321115696',
    'expires_at' => Carbon::now()->addHours(6),
    'created_at' => now(),
    'updated_at' => now()
]);

Para rodar o seeder, execute:

php artisan db:seed --class=TokenSeeder

Executando a API
Após configurar o ambiente e rodar as migrations e seeders, inicie o servidor:

php artisan serve
A API estará disponível em: 🔗 http://127.0.0.1:8000


###Passos para configurar o banco de dados no Laravel
1️⃣ Verifique se o MySQL está rodando
Se estiver usando XAMPP, MAMP ou Docker, certifique-se de que o MySQL está ativo.

2️⃣ Crie o banco de dados
Abra o MySQL e execute:
CREATE DATABASE api_mercado_livre;

3️⃣ Confirme que o .env está correto
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_mercado_livre
DB_USERNAME=root
DB_PASSWORD=



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
✅ Para rodar o front do vue js -> npm run dev  
✅ Caso não rode baixa o dependicia -> npm install
## 📂 Como Executar o Projeto

### 🔧 Backend (Laravel 10)

1. Clone o repositório:
   ```sh
   git clone https://github.com/seu-usuario/seu-repositorio.git
   cd seu-repositorio/backend



######Resposta ao Chamado #742 - LogManager

####Falha na Atualização do Status das Entregas
##Entregas não estão sendo atualizadas para o status "ENTREGUE", mesmo quando o motorista confirma a entrega.
➡️ Na verdade o codigo ele atualiza o status "ENTREGUE" , porem ele não verifica se tem um nova mudança valida. Por exemplo: uma entrega pode mudar para "ENTREGUE" sem ter sido despachada antes.
A solução para isso seria fazer a validação da ordem dos status antes de atualiza

##Entregas voltando para o status "EM ROTA" automaticamente (sem que nenhuma atualização seja feita).
➡️ Pode estar tendo duplicidade nos eventos ou concorrência na gravação de status.
A solução para isso uso de lock otimista para evitar concorrência entre atualizações simultâneas

##Há registros de pacotes sendo entregues antes de serem despachados, indicando um erro na ordem dos eventos.
➡️O sistema esta permitindo que um status "ENTREGUE" seja adicionado antes de "DESPACHO", o que é um erro lógico.
E uma solução é fazer uma verificação se o status anterior permite fazer uma mudança no novo status.



####Consulta Extrema no Relatório de Entregas

##O primeiro problema que foi indentificado foi o uso da QUERY BRUTO.
➡️ O uso do DB::select($query) torna mais dificil de realizar a otimização do SLQ Injection.
Uma solução para este problema é a utilização do Eloquent ORM com whereIn()  ou whereBetween(), isso melhora a segurança e a legebilidade

##O segundo problema que foi identidicado foi o filtro dentro do IN()
➡️O sistema esta permitindo que um status "ENTREGUE" seja adicionado antes de "DESPACHO", o que é um erro lógico.
E uma solução para isso é colocar índices nos campos que foram filtrados como "status", "courier","delivery_date",.

##O terceiro problema e ultimo que encontrei foi idexação
➡️o que esta acontecendo é que esta tendo uma busca nas colunas que não estão adequadas, com isso causa a lentidão.
Uma solução para isso é reduzir o numero de colunas retornadas, e selecionar apanas o que é necessario 





####Código Atualizado

## Atualização do Status da Entrega

public function updateDeliveryStatus(Request $request)
{
    DB::beginTransaction();
    try {
        $delivery = Delivery::where('tracking_code', $request->tracking_code)->lockForUpdate()->first();
        
        if (!$delivery) {
            return response()->json(['error' => 'Entrega não encontrada'], 404);
        }
        
        // Valida transição de status
        $statusPermitidos = [
            'PENDENTE' => ['DESPACHADO'],
            'DESPACHADO' => ['EM ROTA'],
            'EM ROTA' => ['ENTREGUE', 'FALHA'],
        ];

        if (!isset($statusPermitidos[$delivery->status]) || !in_array($request->status, $statusPermitidos[$delivery->status])) {
            return response()->json(['error' => 'Transição de status inválida'], 400);
        }
        
        $delivery->status = $request->status;
        $delivery->save();

        DeliveryEvent::create([
            'delivery_id' => $delivery->id,
            'status' => $request->status,
            'timestamp' => now(),
        ]);
        
        DB::commit();
        return response()->json(['message' => 'Status atualizado com sucesso']);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['error' => 'Erro ao atualizar status'], 500);
    }
}

## Otimização da Query de Relatório


public function getDeliveryReport(Request $request)
{
    $deliveries = Delivery::with('packages')
        ->whereIn('status', $request->statuses)
        ->whereIn('courier', $request->couriers)
        ->whereBetween('delivery_date', [$request->start_date, $request->end_date])
        ->get();

    return response()->json($deliveries);
}

## Melhorias na Indexação
CREATE INDEX idx_status ON deliveries(status);
CREATE INDEX idx_courier ON deliveries(courier);
CREATE INDEX idx_delivery_date ON deliveries(delivery_date);













