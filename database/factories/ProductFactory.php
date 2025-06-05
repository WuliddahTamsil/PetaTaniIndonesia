<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random category ID from existing categories
        $categoryId = Category::inRandomOrder()->first()?->id;

        $productName = $this->faker->words(2, true) . ' ' . $this->faker->randomElement(['Segar', 'Organik', 'Pilihan']);
        $description = $this->faker->sentence();
        $price = $this->faker->randomFloat(2, 1000, 50000);
        $isDiscounted = $this->faker->boolean(25); // 25% chance of being discounted
        $discountPrice = $isDiscounted ? $price * $this->faker->randomFloat(2, 0.5, 0.9) : null;
        $stock = $this->faker->numberBetween(0, 100);
        $image = 'placeholder.jpg'; // Placeholder image name

        return [
            'name' => $productName,
            'description' => $description,
            'price' => $price,
            'discount_price' => $discountPrice,
            'image' => $image,
            'stock' => $stock,
            'is_discounted' => $isDiscounted,
            'category_id' => $categoryId,
        ];
    }

    // Optional: state for discounted products
    public function discounted()
    {
        return $this->state(function (array $attributes) {
            $price = $this->faker->randomFloat(2, 1000, 50000);
            return [
                'price' => $price,
                'is_discounted' => true,
                'discount_price' => $price * $this->faker->randomFloat(2, 0.5, 0.9),
            ];
        });
    }
} 