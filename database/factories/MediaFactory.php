<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileName = fake()->uuid().'.jpg';

        return [
            'site_id' => Site::factory(),
            'user_id' => User::factory(),
            'disk' => 'public',
            'path' => 'media/'.$fileName,
            'original_name' => $fileName,
            'mime_type' => 'image/jpeg',
            'size' => fake()->numberBetween(10_000, 500_000),
            'alt_text' => fake()->sentence(3),
        ];
    }
}
