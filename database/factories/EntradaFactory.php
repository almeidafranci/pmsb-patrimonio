<?php

namespace Database\Factories;

use App\Enums\EntradaStatus;
use App\Models\Entrada;
use App\Models\Fornecedor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Entrada>
 */
class EntradaFactory extends Factory
{
    protected $model = Entrada::class;

    public function definition(): array
    {
        return [
            'fornecedor_id' => Fornecedor::factory(),
            'numero_nota' => fake()->numerify('NF-######'),
            'data_entrada' => fake()->date(),
            'observacao' => fake()->optional()->sentence(),
            'usuario_id' => User::factory(),
            'status' => EntradaStatus::Rascunho,
        ];
    }

    public function confirmada(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EntradaStatus::Confirmada,
        ]);
    }
}
