<?php

namespace App\Http\Controllers;

use App\Services\MercadoLivreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Token;
use App\Models\Produto;



class MercadoLivreController extends Controller
{
    protected $service;
    // Definindo as credenciais globalmente
    protected $clientId = '3743748400398289';
    protected $clientSecret = 'uGFhdet0RVKpZqGrvNfGeFfdS6BkAQEV';

    public function __construct(MercadoLivreService $service)
    {
        $this->service = $service;
    }

    // Redireciona para a autorização do Mercado Livre
    public function redirectToAuth()
    {
        return redirect($this->service->getAuthorizationUrl());
    }

    // Manipula o callback de autorização e salva o token no banco
    public function handleCallback(Request $request)
    {
        if (!$request->has('code')) {
            return response()->json(['error' => 'Código de autorização não encontrado'], 400);
        }

        $tokenData = $this->service->handleCallback($request->code);

        if (!$tokenData) {
            return response()->json(['error' => 'Falha ao obter token'], 500);
        }

        // Salvar ou atualizar o token no banco
        Token::updateOrCreate([], [
            'access_token' => $tokenData->access_token,
            'refresh_token' => $tokenData->refresh_token,
            'expires_at' =>  Carbon::now()->addSeconds($tokenData->expires_in),
        ]);

        return response()->json(['message' => 'Autorizado com sucesso', 'token' => $tokenData]);
    }

    // Renova o token de acesso
    public function refreshAccessToken()
    {
        $token = Token::latest()->first();

        if (!$token) {
            return response()->json(['error' => 'Token não encontrado'], 400);
        }

        // Se o token expirou, renová-lo
        if (now()->greaterThan($token->expires_at)) {
            $response = Http::asForm()->post('https://api.mercadolibre.com/oauth/token', [
                'grant_type' => 'refresh_token',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'refresh_token' => $token->refresh_token,
            ]);

            if ($response->failed()) {
                return response()->json(['error' => 'Falha ao renovar token', 'details' => $response->json()], 400);
            }

            $data = $response->json();
            $token->update([
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
                'expires_at' => now()->addSeconds($data['expires_in']),
            ]);

            return response()->json(['message' => 'Token renovado com sucesso', 'token' => $token]);
        }
        //Token não expirou

        return response()->json(['message' => 'Token ainda válido', 'token' => $token]);
    }



    public function getToken(){

        $token = Token::all();
        return response()->json($token);
    }
    public function buscaToken($id){

        $token = Token::find($id);
        return response()->json($token);
    }


    public function updateToken(Request $request, $id)
    {
        $token = Token::find($id);

        if (!$token) {
            return response()->json(['mensagem' => 'Token não localizado'], 404);
        }

        $dadosAtualizados = [];

        if ($request->has('access_token')) {
            $dadosAtualizados['access_token'] = $request->input('access_token');
        }

        if ($request->has('refresh_token')) {
            $dadosAtualizados['refresh_token'] = $request->input('refresh_token');
        }

        if ($request->has('expires_at')) {
            $dadosAtualizados['expires_at'] = Carbon::parse($request->input('expires_at'));
        }

        if (empty($dadosAtualizados)) {
            return response()->json(['mensagem' => 'Nenhum campo para atualização foi fornecido'], 400);
        }

        $token->update($dadosAtualizados);

        return response()->json([
            'mensagem' => 'Token atualizado com sucesso!',
            'token' => $token
        ]);
    }
    
    public function deleteToken($id)
    {
        $token = Token::find($id);

        if (!$token) {
            return response()->json(['mensagem' => 'Token não localizado'], 404);
        }

        $token->delete();

        return response()->json(null, 204);
    }



}
