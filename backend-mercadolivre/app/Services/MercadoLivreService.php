<?php

namespace App\Services;

use App\Models\MercadoLivreToken;
use Illuminate\Support\Facades\Http;

class MercadoLivreService
{
    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;

    public function __construct()
    {
        $this->client_id = '3743748400398289';
        $this->client_secret = 'uGFhdet0RVKpZqGrvNfGeFfdS6BkAQEV';
        $this->redirect_uri = 'https://www.logmanager.com.br/';
    }

    public function getAuthorizationUrl(): string
    {
        return "https://auth.mercadolivre.com.br/authorization?response_type=code&client_id={$this->client_id}&redirect_uri={$this->redirect_uri}";
    }

    public function handleCallback(string $code)
    {
        $response = Http::asForm()->post('https://api.mercadolibre.com/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'code' => $code,
            'redirect_uri' => $this->redirect_uri,
        ]);

        if ($response->failed()) {
            Log::error('Erro ao obter token do Mercado Livre', ['response' => $response->json()]);
            return null;
        }

        $data = $response->json();

        return MercadoLivreToken::updateOrCreate(
            ['user_id' => $data['user_id']],
            [
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'] ?? null, // Pode não vir
                'expires_at' => now()->addSeconds($data['expires_in']),
            ]
        );
    }


  public function getValidToken(int $user_id)
    {
        $token = MercadoLivreToken::where('user_id', $user_id)->first();

        if (!$token) {
            Log::warning("Nenhum token encontrado para o usuário: {$user_id}");
            return null;
        }

        if (now()->greaterThan($token->expires_at)) {
            return $this->refreshToken($user_id);
        }

        return $token->access_token;
    }


    public function refreshToken(int $user_id)
    {
        $token = MercadoLivreToken::where('user_id', $user_id)->first();

        if (!$token || !$token->refresh_token) {
            Log::error("Não há refresh_token válido para o usuário {$user_id}");
            return null;
        }

        $response = Http::asForm()->post('https://api.mercadolibre.com/oauth/token', [
            'grant_type' => 'refresh_token',
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'refresh_token' => $token->refresh_token,
        ]);

        if ($response->failed()) {
            Log::error('Erro ao renovar token do Mercado Livre', ['response' => $response->json()]);
            return null;
        }

        $data = $response->json();

        $token->update([
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'] ?? $token->refresh_token, // Se não vier, mantém o antigo
            'expires_at' => now()->addSeconds($data['expires_in']),
        ]);

        return $data['access_token'];
    }

}
