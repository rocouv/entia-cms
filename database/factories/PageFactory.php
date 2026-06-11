<?php

namespace Database\Factories;

use App\Models\Page;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
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
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->sentence(),
            'body' => fake()->paragraphs(3, true),
            'is_home' => false,
            'is_published' => true,
            'show_in_navigation' => true,
            'navigation_label' => null,
            'sort_order' => fake()->numberBetween(0, 100),
            'meta_title' => $title,
            'meta_description' => fake()->sentence(),
        ];
    }
}
