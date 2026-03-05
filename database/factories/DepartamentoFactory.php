<?php

namespace Database\Factories;

use App\Models\Departamento;
use App\Models\Secretaria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Departamento>
 */
class DepartamentoFactory extends Factory
{
    protected $model = Departamento::class;

    public function definition(): array
    {
        $nome = fake()->unique()->words(2, true);

        return [
            'secretaria_id' => Secretaria::factory(),
            'nome' => ucfirst($nome),
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
