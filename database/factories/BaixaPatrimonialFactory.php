<?php

namespace Database\Factories;

use App\Enums\BaixaMotivo;
use App\Models\BaixaPatrimonial;
use App\Models\Tombamento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BaixaPatrimonial>
 */
class BaixaPatrimonialFactory extends Factory
{
    protected $model = BaixaPatrimonial::class;

    public function definition(): array
    {
        return [
            'tombamento_id' => Tombamento::factory(),
            'data_baixa' => fake()->date(),
            'motivo' => fake()->randomElement(BaixaMotivo::cases()),
            'descricao' => fake()->optional()->sentence(),
            'usuario_id' => User::factory(),
        ];
    }
}
