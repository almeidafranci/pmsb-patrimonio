<?php

namespace Database\Factories;

use App\Enums\TombamentoStatus;
use App\Models\EntradaItem;
use App\Models\Item;
use App\Models\Tombamento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tombamento>
 */
class TombamentoFactory extends Factory
{
    protected $model = Tombamento::class;

    public function definition(): array
    {
        return [
            'item_id' => Item::factory(),
            'entrada_item_id' => EntradaItem::factory(),
            'numero_tombamento' => null,
            'secretaria_id' => null,
            'departamento_id' => null,
            'valor' => fake()->randomFloat(2, 100, 10000),
            'data_tombamento' => null,
            'status' => TombamentoStatus::Pendente,
            'observacao' => null,
            'usuario_id' => User::factory(),
        ];
    }

    public function ativo(): static
    {
        return $this->state(fn (array $attributes) => [
            'numero_tombamento' => fake()->unique()->numerify('TB-######'),
            'data_tombamento' => fake()->date(),
            'status' => TombamentoStatus::Ativo,
        ]);
    }
}
