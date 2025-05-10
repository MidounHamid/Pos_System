<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;

class CategoriesAndBrandsSeeder extends Seeder
{
    public function run(): void
    {
        // Categories from the image
        $categories = [
            'Fruits',
            'Shoes',
            'Jackets',
            'Computer',
            'T-shirts',
            'Sunglass',
            'EarPods'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'description' => 'Description for ' . $category
            ]);
        }

        // Brands from the image
        $brands = [
            'Colorss',
            'Lion Test',
            'Laptop',
            'A & S Company',
            'Fruits',
            'HP',
            'trestllqa'
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand,
                'description' => 'Description for ' . $brand
            ]);
        }
    }
}
