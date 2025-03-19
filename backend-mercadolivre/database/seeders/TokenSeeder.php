<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tokens')->insert([
            'access_token' => 'APP_USR-3743748400398289-031908-f3ba763a2925a204e168c9b45c1f79e2-321115696',
            'refresh_token' => 'TG-67daa1da9a882000011f9a33-321115696',
            'expires_at' => Carbon::now()->addHours(6),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
