<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Menu;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Döner' => [
                ['name' => 'Chicken Döner', 'price' => 120],
                ['name' => 'Beef Döner', 'price' => 140],
                ['name' => 'Mixed Döner', 'price' => 150],
                ['name' => 'Döner Plate', 'price' => 180],
            ],

            'Pizza' => [
                ['name' => 'Margherita Pizza', 'price' => 180],
                ['name' => 'Pepperoni Pizza', 'price' => 220],
                ['name' => 'Chicken Pizza', 'price' => 210],
                ['name' => 'Vegetable Pizza', 'price' => 190],
            ],

            'Burger' => [
                ['name' => 'Classic Burger', 'price' => 130],
                ['name' => 'Cheese Burger', 'price' => 150],
                ['name' => 'Chicken Burger', 'price' => 140],
                ['name' => 'Double Burger', 'price' => 190],
            ],

            'Pasta' => [
                ['name' => 'Spaghetti', 'price' => 160],
                ['name' => 'Penne Arrabbiata', 'price' => 170],
                ['name' => 'Chicken Alfredo', 'price' => 210],
                ['name' => 'Lasagna', 'price' => 220],
            ],

            'Drinks' => [
                ['name' => 'Cola', 'price' => 40],
                ['name' => 'Ayran', 'price' => 30],
                ['name' => 'Water', 'price' => 20],
                ['name' => 'Orange Juice', 'price' => 60],
                ['name' => 'Tea', 'price' => 25],
                ['name' => 'Coffee', 'price' => 50],
            ],

            'Desserts' => [
                ['name' => 'Kunafa', 'price' => 120],
                ['name' => 'Baklava', 'price' => 100],
                ['name' => 'Cheesecake', 'price' => 140],
                ['name' => 'Ice Cream', 'price' => 80],
            ],
        ];

        foreach ($categories as $categoryName => $menus) {
            $category = Category::create([
                'name' => $categoryName
            ]);

            foreach ($menus as $menu) {
                Menu::create([
                    'name' => $menu['name'],
                    'price' => $menu['price'],
                    'category_id' => $category->id
                ]);
            }
        }
    }
}