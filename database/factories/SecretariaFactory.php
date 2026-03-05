<?php

namespace Database\Factories;

use App\Models\Secretaria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Secretaria>
 */
class SecretariaFactory extends Factory
{
    protected $model = Secretaria::class;

    public function definition(): array
    {
        $nome = fake()->unique()->company();

        return [
            'nome' => $nome,
            'sigla' => strtoupper(mb_substr($nome, 0, 3)),
            'ativo' => true,
        ];
    }

    public function inativo(): static
    {
        return $this->state(fn (array $attributes) => [
            'ativo' => false,
        ]);
    }
}
