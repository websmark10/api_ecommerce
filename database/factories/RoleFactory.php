<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Core\DateTime;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        ///https://fakerphp.github.io/
        return [
           'name'=>$this->faker->word(),
           'created_at' => $this->faker->dateTime() ,
           'updated_at' =>$this->faker->dateTime(),
        ];
    }
}
