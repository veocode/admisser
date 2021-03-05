<?php
namespace Database\Factories;

use App\Models\StudentProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $phoneCode = $this->faker->randomElement([999, 922, 911, 900]);
        $phone1 = rand(111, 999);
        $phone2 = rand(11, 99);
        $phone3 = rand(11, 99);
        $phone = "+7 ({$phoneCode}) {$phone1}-{$phone2}-{$phone3}";

        return [
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement([9, 11]),
            'gender' => $this->faker->randomElement(['m', 'f']),
            'phone' => $phone
        ];
    }
}