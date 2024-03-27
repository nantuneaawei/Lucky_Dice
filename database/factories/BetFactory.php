<?php

namespace Database\Factories;

use App\Models\Mydb\Bet;
use App\Models\Mydb\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

class BetFactory extends Factory
{
    protected $model = Bet::class;

    public function definition(): array
    {
        $sBetType = $this->faker->randomElement(['number', 'color', 'odd_even']);
        $mBetContent = null;

        switch ($sBetType) {
            case 'number':
                $mBetContent = $this->faker->numberBetween(0, 36);
                break;
            case 'color':
                $mBetContent = $this->faker->randomElement(['red', 'black']);
                break;
            case 'odd_even':
                $mBetContent = $this->faker->randomElement(['odd', 'even']);
                break;
        }

        $iNextBetId = Bet::max('bet_id') + 1;

        return [
            'player_id' => Player::factory()->create()->id,
            'bet_id' => $iNextBetId,
            'bet_type' => $sBetType,
            'bet_content' => $mBetContent,
            'bet_amount' => $this->faker->numberBetween(10, 1000),
            'game_result' => $mBetContent,
            'profit_loss' => $this->faker->randomFloat(2, -1000, 1000),
        ];
    }

}
