<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Famille;

class FamilleSeeder extends Seeder
{
    public function run(): void
    {
        $familles = [
            ['famille' => 'Fruits', 'photo' => 'fruits.jpg'],
            ['famille' => 'Shoes', 'photo' => 'shoes.jpg'],
            ['famille' => 'Jackets', 'photo' => 'jackets.jpg'],
            ['famille' => 'Computer', 'photo' => 'computer.jpg'],
            ['famille' => 'T-shirts', 'photo' => 'tshirts.jpg'],
            ['famille' => 'Sunglass', 'photo' => 'sunglass.jpg'],
            ['famille' => 'EarPods', 'photo' => 'earpods.jpg']
        ];

        foreach ($familles as $famille) {
            Famille::create($famille);
        }
    }
}
