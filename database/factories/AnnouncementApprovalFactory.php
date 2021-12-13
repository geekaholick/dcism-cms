<?php

namespace Database\Factories;

use App\Models\AnnouncementApproval;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementApprovalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AnnouncementApproval::class;

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
            'is_approved' => $this->faker->randomElement([0, 1])
        ];
    }
}
