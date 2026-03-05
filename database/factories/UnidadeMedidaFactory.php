<?php

namespace Database\Factories;

use App\Models\UnidadeMedida;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UnidadeMedida>
 */
class UnidadeMedidaFactory extends Factory
{
    protected $model = UnidadeMedida::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->unique()->word(),
            'sigla' => strtoupper(fake()->unique()->lexify('??')),
        ];
    }
}
