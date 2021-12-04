<?php

namespace Database\Factories;

use App\Models\UserPrivileges;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserPrivilegesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserPrivileges::class;

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
            'privilege_id' => $this->faker->numberBetween(1,3)
        ];
    }
}
