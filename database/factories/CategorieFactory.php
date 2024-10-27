<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategorieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->word(),
           'imagen'=> $this->faker->imageUrl(640, 480, 'animals', true),
           'icono' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
           'state'=>1,
           'created_at' => $this->faker->dateTime() ,
           'updated_at' =>$this->faker->dateTime(),
        ];
    }
}
