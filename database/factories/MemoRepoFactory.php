<?php

namespace Database\Factories;

use App\Models\MemoRepo;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemoRepoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MemoRepo::class;

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
            'memo_path' => 'this is a path to where memo are located'
        ];
    }
}
