<?php

namespace Database\Factories;

use App\Models\Notifications;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notifications::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'announcement_id' => $this->faker->numberBetween(1, 150),
            'user_id' => $this->faker->numberBetween(1, 5),
            'have_opened' => $this->faker->randomElement([0, 1])
        ];
    }
}
