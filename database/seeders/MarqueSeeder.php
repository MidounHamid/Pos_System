<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marque;

class MarqueSeeder extends Seeder
{
    public function run(): void
    {
        $marques = [
            ['marque' => 'Colorss', 'photo' => 'colorss.jpg'],
            ['marque' => 'Lion Test', 'photo' => 'lion-test.jpg'],
            ['marque' => 'Laptop', 'photo' => 'laptop.jpg'],
            ['marque' => 'A & S Company', 'photo' => 'as-company.jpg'],
            ['marque' => 'Fruits', 'photo' => 'fruits.jpg'],
            ['marque' => 'HP', 'photo' => 'hp.jpg'],
            ['marque' => 'trestllqa', 'photo' => 'trestllqa.jpg']
        ];

        foreach ($marques as $marque) {
            Marque::create($marque);
        }
    }
}
