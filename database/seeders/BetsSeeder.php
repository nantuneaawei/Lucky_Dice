<?php

namespace Database\Seeders;

use App\Models\Mydb\Bet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(PlayersSeeder::class);

        Bet::factory()->count(5)->create();
    }
}
