<?php

namespace Database\Factories;

use App\Models\Departamento;
use App\Models\Secretaria;
use App\Models\Tombamento;
use App\Models\TransferenciaPatrimonial;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TransferenciaPatrimonial>
 */
class TransferenciaPatrimonialFactory extends Factory
{
    protected $model = TransferenciaPatrimonial::class;

    public function definition(): array
    {
        return [
            'tombamento_id' => Tombamento::factory(),
            'secretaria_origem_id' => Secretaria::factory(),
            'departamento_origem_id' => Departamento::factory(),
            'secretaria_destino_id' => Secretaria::factory(),
            'departamento_destino_id' => Departamento::factory(),
            'data_transferencia' => fake()->date(),
            'motivo' => fake()->sentence(),
            'observacao' => fake()->optional()->sentence(),
            'usuario_id' => User::factory(),
        ];
    }
}
