<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Service;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'site_id' => Site::factory(),
            'category_id' => null,
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->sentence(),
            'body' => fake()->paragraphs(3, true),
            'image_path' => null,
            'is_published' => true,
            'is_featured' => false,
            'sort_order' => fake()->numberBetween(0, 100),
            'meta_title' => $title,
            'meta_description' => fake()->sentence(),
        ];
    }

    public function withCategory(): static
    {
        return $this->state(fn (array $attributes): array => [
            'category_id' => Category::factory()->create([
                'site_id' => $attributes['site_id'],
            ])->id,
        ]);
    }
}
