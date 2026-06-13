<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@humewear.pk',
            'password' => 'admin@123',
        ]);

        $products = [
            ['title' => 'Floral Summer Dress', 'description' => 'A beautiful floral print midi dress with flowy silhouette. Perfect for summer days and evening gatherings. Made from 100% cotton with a breathable lining.', 'price' => 4500, 'size' => 'S, M, L, XL', 'category' => 'Dresses'],
            ['title' => 'Elegant Evening Gown', 'description' => 'Stunning floor-length evening gown with intricate embroidery. Features a sweetheart neckline and a fitted bodice that flares into a graceful skirt.', 'price' => 12500, 'size' => 'S, M, L', 'category' => 'Dresses'],
            ['title' => 'Pearl Drop Earrings', 'description' => 'Handcrafted pearl drop earrings with sterling silver hooks. Each pearl is carefully selected for its luster and shape.', 'price' => 2800, 'size' => 'One Size', 'category' => 'Accessories'],
            ['title' => 'Cashmere Wrap Scarf', 'description' => 'Luxuriously soft cashmere blend scarf in neutral tones. Adds elegance to any outfit while keeping you warm.', 'price' => 3500, 'size' => 'One Size', 'category' => 'Accessories'],
            ['title' => 'Tailored Blazer', 'description' => 'Sharp tailored blazer with a modern cut. Features notched lapels, padded shoulders, and a single-breasted closure.', 'price' => 8900, 'size' => 'S, M, L, XL', 'category' => 'Outerwear'],
            ['title' => 'Leather Crossbody Bag', 'description' => 'Genuine leather crossbody bag with gold-toned hardware. Features an adjustable strap and multiple interior pockets.', 'price' => 6500, 'size' => 'One Size', 'category' => 'Accessories'],
            ['title' => 'Silk Evening Top', 'description' => 'Pure silk blouse with a subtle sheen. Features a draped neckline and elegant tulip sleeves.', 'price' => 5800, 'size' => 'S, M, L', 'category' => 'Tops'],
            ['title' => 'Wide Leg Trousers', 'description' => 'High-waisted wide leg trousers in premium crepe fabric. Flowing silhouette that creates an elegant, elongated look.', 'price' => 6200, 'size' => 'XS, S, M, L, XL', 'category' => 'Bottoms'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}