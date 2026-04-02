<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Player::truncate();

        $players = [
            ['Name' => 'Connor McDavid', 'Team' => 'Edmonton Oilers'],
            ['Name' => 'Leon Draisaitl', 'Team' => 'Edmonton Oilers'],
            ['Name' => 'Sidney Crosby', 'Team' => 'Pittsburgh Penguins'],
            ['Name' => 'Auston Matthews', 'Team' => 'Toronto Maple Leafs'],
            ['Name' => 'Nathan MacKinnon', 'Team' => 'Colorado Avalanche'],
            ['Name' => 'LeBron James', 'Team' => 'Los Angeles Lakers'],
            ['Name' => 'Stephen Curry', 'Team' => 'Golden State Warriors'],
            ['Name' => 'Kevin Durant', 'Team' => 'Phoenix Suns'],
            ['Name' => 'Lionel Messi', 'Team' => 'Inter Miami'],
            ['Name' => 'Kylian Mbappe', 'Team' => 'Real Madrid'],
        ];

        foreach ($players as $player) {
            Player::create($player);
        }
    }
}
