<?php

namespace Database\Factories;

use App\Models\Site;
use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SiteSetting>
 */
class SiteSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'site_id' => Site::factory(),
            'site_name' => fake()->company(),
            'tagline' => fake()->sentence(6),
            'contact_email' => fake()->companyEmail(),
            'contact_phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'meta_title' => fake()->sentence(4),
            'meta_description' => fake()->sentence(12),
            'social_links' => [],
        ];
    }
}
