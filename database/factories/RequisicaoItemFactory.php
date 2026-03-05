<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Requisicao;
use App\Models\RequisicaoItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RequisicaoItem>
 */
class RequisicaoItemFactory extends Factory
{
    protected $model = RequisicaoItem::class;

    public function definition(): array
    {
        return [
            'requisicao_id' => Requisicao::factory(),
            'item_id' => Item::factory(),
            'quantidade_solicitada' => fake()->numberBetween(1, 20),
            'quantidade_atendida' => 0,
        ];
    }
}
