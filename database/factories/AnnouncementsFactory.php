<?php

namespace Database\Factories;

use App\Models\Announcements;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Announcements::class;

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
            'memo_id' => $this->faker->numberBetween(1,3),
            'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'body' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
            'comment_no' => $this->faker->numberBetween($min = 1, $max = 5000)
        ];
    }
}
