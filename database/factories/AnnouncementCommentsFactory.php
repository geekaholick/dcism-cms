<?php

namespace Database\Factories;

use App\Models\AnnouncementComments;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementCommentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AnnouncementComments::class;

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
            'user_id' => $this->faker->numberBetween(1,5),
            'comment' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true)
        ];
    }
}
