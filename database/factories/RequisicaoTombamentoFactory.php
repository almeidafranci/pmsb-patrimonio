<?php

namespace Database\Factories;

use App\Models\Requisicao;
use App\Models\RequisicaoTombamento;
use App\Models\Tombamento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RequisicaoTombamento>
 */
class RequisicaoTombamentoFactory extends Factory
{
    protected $model = RequisicaoTombamento::class;

    public function definition(): array
    {
        return [
            'requisicao_id' => Requisicao::factory(),
            'tombamento_id' => Tombamento::factory(),
        ];
    }
}
