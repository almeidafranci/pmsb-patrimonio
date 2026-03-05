<?php

namespace Database\Factories;

use App\Models\Entrada;
use App\Models\EntradaItem;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EntradaItem>
 */
class EntradaItemFactory extends Factory
{
    protected $model = EntradaItem::class;

    public function definition(): array
    {
        return [
            'entrada_id' => Entrada::factory(),
            'item_id' => Item::factory(),
            'quantidade' => fake()->numberBetween(1, 50),
            'valor_unitario' => fake()->randomFloat(2, 10, 5000),
        ];
    }
}
