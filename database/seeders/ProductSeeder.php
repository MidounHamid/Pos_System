<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Famille;
use App\Models\Marque;
use App\Models\Unite;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get a default unite (you should have one created)
        $unite = Unite::first();

        $articles = [
            // Laptops
            [
                'designation' => 'Laptop HP',
                'prix_ht' => 7000.00,
                'tva' => 20,
                'stock' => 403,
                'code_barre' => '12345600',
                'photo' => null,
                'famille' => 'Computer',
                'marque' => 'HP'
            ],
            // T-Shirts
            [
                'designation' => 'T-Shirt Gris',
                'prix_ht' => 11.99,
                'tva' => 20,
                'stock' => 7961,
                'code_barre' => 'C-SHIRT',
                'photo' => null,
                'famille' => 'T-shirts',
                'marque' => 'Colorss'
            ],
            [
                'designation' => 'T-Shirt Blanc',
                'prix_ht' => 11.99,
                'tva' => 20,
                'stock' => 7607,
                'code_barre' => 'WT-001',
                'photo' => null,
                'famille' => 'T-shirts',
                'marque' => 'Lion Test'
            ],
            // Shoes
            [
                'designation' => 'Future Rider Play On Unisex Sneakers',
                'prix_ht' => 950.00,
                'tva' => 20,
                'stock' => 6088,
                'code_barre' => '098742',
                'photo' => null,
                'famille' => 'Shoes',
                'marque' => 'Lion Test'
            ],
            [
                'designation' => 'Studs Sport',
                'prix_ht' => 100.00,
                'tva' => 20,
                'stock' => 9054,
                'code_barre' => 'STUDS',
                'photo' => null,
                'famille' => 'Shoes',
                'marque' => 'A & S Company'
            ],
            // Sunglasses
            [
                'designation' => 'Lunettes de Soleil Noir',
                'prix_ht' => 99.00,
                'tva' => 20,
                'stock' => 8875,
                'code_barre' => '100100',
                'photo' => null,
                'famille' => 'Sunglass',
                'marque' => 'trestllqa'
            ],
            // Fruits
            [
                'designation' => 'Pomme Fraîche',
                'prix_ht' => 3.00,
                'tva' => 5.5,
                'stock' => 6735,
                'code_barre' => 'FR-001',
                'photo' => null,
                'famille' => 'Fruits',
                'marque' => 'Fruits'
            ],
            [
                'designation' => 'Orange',
                'prix_ht' => 2.50,
                'tva' => 5.5,
                'stock' => 5430,
                'code_barre' => 'FR-002',
                'photo' => null,
                'famille' => 'Fruits',
                'marque' => 'Fruits'
            ],
            // EarPods
            [
                'designation' => 'EarPods Pro Sans Fil',
                'prix_ht' => 199.99,
                'tva' => 20,
                'stock' => 342,
                'code_barre' => 'EP-001',
                'photo' => null,
                'famille' => 'EarPods',
                'marque' => 'A & S Company'
            ],
            // Jackets
            [
                'designation' => 'Veste d\'Hiver',
                'prix_ht' => 89.99,
                'tva' => 20,
                'stock' => 234,
                'code_barre' => 'JK-001',
                'photo' => null,
                'famille' => 'Jackets',
                'marque' => 'Colorss'
            ],
            // Additional Computer Items
            [
                'designation' => 'Écran Gaming HP',
                'prix_ht' => 299.99,
                'tva' => 20,
                'stock' => 156,
                'code_barre' => 'MON-001',
                'photo' => null,
                'famille' => 'Computer',
                'marque' => 'HP'
            ],
            [
                'designation' => 'Souris Sans Fil HP',
                'prix_ht' => 29.99,
                'tva' => 20,
                'stock' => 789,
                'code_barre' => 'MS-001',
                'photo' => null,
                'famille' => 'Computer',
                'marque' => 'HP'
            ]
        ];

        foreach ($articles as $articleData) {
            $famille = Famille::where('famille', $articleData['famille'])->first();
            $marque = Marque::where('marque', $articleData['marque'])->first();

            if ($famille && $marque && $unite) {
                Article::create([
                    'designation' => $articleData['designation'],
                    'prix_ht' => $articleData['prix_ht'],
                    'tva' => $articleData['tva'],
                    'stock' => $articleData['stock'],
                    'photo' => $articleData['photo'],
                    'code_barre' => $articleData['code_barre'],
                    'famille_id' => $famille->id,
                    'marque_id' => $marque->id,
                    'unite_id' => $unite->id
                ]);
            }
        }
    }
}
