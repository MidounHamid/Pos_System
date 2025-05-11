<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Famille;
use App\Models\Marque;
use App\Models\Unite;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // On récupère les premières familles, marques et unités existantes
        $famille = Famille::first();
        $marque = Marque::first();
        $unite = Unite::first();

        // On vérifie qu'ils existent
        if ($famille && $marque && $unite) {
            Article::create([
                'designation' => 'Pomme Golden',
                'prix_ht' => 2.50,
                'tva' => 7,
                'stock' => 100,
                'photo' => 'images/images.png',
                'code_barre' => '1234567890123',
                'famille_id' => $famille->id,
                'marque_id' => $marque->id,
                'unite_id' => $unite->id,
            ]);
            Article::create([
                'designation' => 'Orange Maroc',
                'prix_ht' => 3.00,
                'tva' => 7,
                'stock' => 80,
                'photo' => 'images/images.png',
                'code_barre' => '9876543210987',
                'famille_id' => $famille->id,
                'marque_id' => $marque->id,
                'unite_id' => $unite->id,
            ]);
            Article::create([
                'designation' => 'Banane',
                'prix_ht' => 2.20,
                'tva' => 7,
                'stock' => 60,
                'photo' => 'images/images.png',
                'code_barre' => '1111111111111',
                'famille_id' => $famille->id,
                'marque_id' => $marque->id,
                'unite_id' => $unite->id,
            ]);
            Article::create([
                'designation' => 'Tomate',
                'prix_ht' => 1.80,
                'tva' => 7,
                'stock' => 120,
                'photo' => 'images/images.png',
                'code_barre' => '2222222222222',
                'famille_id' => $famille->id,
                'marque_id' => $marque->id,
                'unite_id' => $unite->id,
            ]);
            Article::create([
                'designation' => 'Poivron Vert',
                'prix_ht' => 2.00,
                'tva' => 7,
                'stock' => 90,
                'photo' => 'images/images.png',
                'code_barre' => '3333333333333',
                'famille_id' => $famille->id,
                'marque_id' => $marque->id,
                'unite_id' => $unite->id,
            ]);
            Article::create([
                'designation' => 'Carotte',
                'prix_ht' => 1.50,
                'tva' => 7,
                'stock' => 110,
                'photo' => 'images/images.png',
                'code_barre' => '4444444444444',
                'famille_id' => $famille->id,
                'marque_id' => $marque->id,
                'unite_id' => $unite->id,
            ]);
            Article::create([
                'designation' => 'Oignon',
                'prix_ht' => 1.30,
                'tva' => 7,
                'stock' => 130,
                'photo' => 'images/images.png',
                'code_barre' => '5555555555555',
                'famille_id' => $famille->id,
                'marque_id' => $marque->id,
                'unite_id' => $unite->id,
            ]);
            Article::create([
                'designation' => 'Pomme de Terre',
                'prix_ht' => 1.10,
                'tva' => 7,
                'stock' => 140,
                'photo' => 'images/images.png',
                'code_barre' => '6666666666666',
                'famille_id' => $famille->id,
                'marque_id' => $marque->id,
                'unite_id' => $unite->id,
            ]);
            Article::create([
                'designation' => 'Courgette',
                'prix_ht' => 1.90,
                'tva' => 7,
                'stock' => 70,
                'photo' => 'images/images.png',
                'code_barre' => '7777777777777',
                'famille_id' => $famille->id,
                'marque_id' => $marque->id,
                'unite_id' => $unite->id,
            ]);
            Article::create([
                'designation' => 'Aubergine',
                'prix_ht' => 2.10,
                'tva' => 7,
                'stock' => 50,
                'photo' => 'images/images.png',
                'code_barre' => '8888888888888',
                'famille_id' => $famille->id,
                'marque_id' => $marque->id,
                'unite_id' => $unite->id,
            ]);
        }
    }
} 