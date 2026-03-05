<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Item;
use App\Models\UnidadeMedida;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'categoria_id' => Categoria::factory(),
            'unidade_medida_id' => UnidadeMedida::factory(),
            'nome' => fake()->unique()->words(3, true),
            'descricao' => fake()->optional()->sentence(),
            'requer_tombamento' => false,
            'estoque_minimo' => fake()->numberBetween(5, 50),
            'estoque_atual' => fake()->numberBetween(0, 100),
        ];
    }

    public function comTombamento(): static
    {
        return $this->state(fn (array $attributes) => [
            'requer_tombamento' => true,
        ]);
    }

    public function estoqueCritico(): static
    {
        return $this->state(fn (array $attributes) => [
            'estoque_minimo' => 10,
            'estoque_atual' => fake()->numberBetween(0, 10),
        ]);
    }
}
