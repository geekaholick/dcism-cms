<?php

namespace Database\Factories;

use App\Models\user_privileges;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserPrivilegesFactory extends Factory
{
    protected $model = user_privileges::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->user_id,
            'privilege_id' => $this->faker->privilege_id
        ];
    }
}
