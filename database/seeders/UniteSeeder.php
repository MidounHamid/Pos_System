<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unite;

class UniteSeeder extends Seeder
{
    public function run(): void
    {
        $unites = [
            ['unite' => 'Pièce'],
            ['unite' => 'Kg'],
            ['unite' => 'g'],
            ['unite' => 'L'],
            ['unite' => 'mL'],
            ['unite' => 'Paire']
        ];

        foreach ($unites as $unite) {
            Unite::create($unite);
        }
    }
}
