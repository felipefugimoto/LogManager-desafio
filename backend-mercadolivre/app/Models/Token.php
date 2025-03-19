<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Token extends Model
{
    use HasFactory;

    protected $table = 'tokens'; // Define a tabela associada ao modelo

    protected $fillable = [
        'access_token',
        'refresh_token',
        'expires_at',
    ];


}
