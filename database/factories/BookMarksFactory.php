<?php

namespace Database\Factories;

use App\Models\Bookmarks;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookMarksFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bookmarks::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'user_id' => $this->faker->numberBetween(1,5),
            'announcement_id' => $this->faker->numberBetween(1,150)
        ];
    }
}
