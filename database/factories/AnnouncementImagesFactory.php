<?php

namespace Database\Factories;

use App\Models\AnnouncementImages;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementImagesFactory extends Factory
{
     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AnnouncementImages::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'announcement_id' => $this->faker->numberBetween(1,150),
            'image_path' => 'this is an image path'
        ];
    }
}
