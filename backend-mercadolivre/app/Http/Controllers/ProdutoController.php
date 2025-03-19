<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use App\Services\MercadoLivreService;
use App\Models\Token;
use App\Models\Produto;

class ProdutoController extends Controller
{
    protected $service;

    public function getAllProduct() {
        $produto = Produto::all();
        return response()->json($produto);

    }

    public function __construct(MercadoLivreService $service)
    {
        $this->service = $service;
    }


    public function cadastraProduto($item_id)
    {
        $token = Token::first(); // Pega o primeiro token salvo

        if (!$token) {
            return response()->json(['error' => 'Token de autenticação não encontrado'], 401);
        }

        $response = Http::withToken($token->access_token)
                        ->get("https://api.mercadolibre.com/items/{$item_id}");

        if ($response->failed()) {
            return response()->json(['error' => 'Falha ao buscar produto'], $response->status());
        }

        // Filtrando apenas os dados desejados
        $produto = $response->json();

        $produtoFiltrado = [
            'titulo' => $produto['title'] ?? null,
            'categoria' => $produto['category_id'] ?? null,
            'preco' => $produto['price'] ?? null,
            'estoque' => $produto['initial_quantity'] ?? null,
        ];

        // Inserindo no banco de dados
    Produto::create($produtoFiltrado);

    return response()->json([
        'message' => 'Produto salvo com sucesso!',
        'produto' => $produtoFiltrado
    ]);
    }


    public function buscarProduto($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        return response()->json($produto);
    }



    public function updateProduto(Request $request, $id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        // Atualiza os campos do produto
        $produto->update([
            'titulo' => $request->titulo ?? $produto->titulo,
            'categoria' => $request->categoria ?? $produto->categoria,
            'preco' => $request->preco ?? $produto->preco,
            'estoque' => $request->estoque ?? $produto->estoque,
        ]);

        return response()->json([
            'message' => 'Produto atualizado com sucesso!',
            'produto' => $produto
        ]);
    }

    public function deletarProduto($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        $produto->delete();

        return response()->json([
            'message' => 'Produto deletado com sucesso!'
        ]);
    }

}
