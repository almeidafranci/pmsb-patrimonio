<?php

namespace Database\Factories;

use App\Enums\MovimentacaoTipo;
use App\Models\Item;
use App\Models\Movimentacao;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Movimentacao>
 */
class MovimentacaoFactory extends Factory
{
    protected $model = Movimentacao::class;

    public function definition(): array
    {
        $saldoAnterior = fake()->numberBetween(0, 100);
        $quantidade = fake()->numberBetween(1, 20);

        return [
            'item_id' => Item::factory(),
            'tipo' => MovimentacaoTipo::Entrada,
            'quantidade' => $quantidade,
            'saldo_anterior' => $saldoAnterior,
            'saldo_atual' => $saldoAnterior + $quantidade,
            'referencia_tipo' => 'entrada',
            'referencia_id' => 1,
            'data' => fake()->date(),
            'usuario_id' => User::factory(),
        ];
    }
}
