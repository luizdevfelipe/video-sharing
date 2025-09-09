<?php

namespace Database\Factories;

use App\Enums\VideoVisibilityEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'video_path' => 'test',
            'thumbnail_path' => 'test.png',
            'visibility' => VideoVisibilityEnum::PUBLIC,
        ];
    }

    public function private(): self
    {
        return $this->state(fn () => ['visibility' => VideoVisibilityEnum::PRIVATE]);
    }
}
