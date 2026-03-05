<?php

namespace Database\Factories;

use App\Enums\RequisicaoStatus;
use App\Models\Requisicao;
use App\Models\Secretaria;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Requisicao>
 */
class RequisicaoFactory extends Factory
{
    protected $model = Requisicao::class;

    public function definition(): array
    {
        return [
            'secretaria_id' => Secretaria::factory(),
            'departamento_id' => null,
            'data_requisicao' => fake()->date(),
            'responsavel' => fake()->name(),
            'observacao' => fake()->optional()->sentence(),
            'usuario_id' => User::factory(),
            'status' => RequisicaoStatus::Rascunho,
        ];
    }

    public function confirmada(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => RequisicaoStatus::Confirmada,
        ]);
    }
}
