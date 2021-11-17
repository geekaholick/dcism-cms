<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'role_id' => $this->faker->numberBetween(1,3),
            'user_email' => $this->faker->unique()->safeEmail,
            'user_password' => 'password',
            'first_name' => $this->faker->name,
            'last_name' => $this->faker->name,
            'user_image' => 'this is a path to a user\'s image',
            'email_verified_at' => now(),
            'verified' => 1,
            'remember_token' => Str::random(10),
            // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }
}
