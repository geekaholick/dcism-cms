<?php

namespace Database\Factories;

use App\Models\PrivilegeLevelInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrivilegeLevelInfoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PrivilegeLevelInfo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'permission' => $this->faker->unique()->randomElement(['Login Module', 'Forgot Password Module', 'Chat Support Module'])
        ];
    }
}
