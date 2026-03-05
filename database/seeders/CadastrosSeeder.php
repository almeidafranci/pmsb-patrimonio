<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Departamento;
use App\Models\Fornecedor;
use App\Models\Item;
use App\Models\Secretaria;
use App\Models\UnidadeMedida;
use Illuminate\Database\Seeder;

class CadastrosSeeder extends Seeder
{
    public function run(): void
    {
        $secretarias = $this->seedSecretarias();
        // $this->seedDepartamentos($secretarias);
        $categorias = $this->seedCategorias();
        $unidades = $this->seedUnidadesMedida();
        // $this->seedFornecedores();
        // $this->seedItens($categorias, $unidades);
    }

    /**
     * @return array<string, Secretaria>
     */
    private function seedSecretarias(): array
    {
        $data = [
            ['nome' => 'Secretaria de Administração e Planejamento', 'sigla' => 'SEMAD'],
            ['nome' => 'Secretaria de Educação', 'sigla' => 'SEMED'],
            ['nome' => 'Secretaria de Saúde', 'sigla' => 'SEMUS'],
            ['nome' => 'Secretaria de Infraestrutura', 'sigla' => 'SEINFRA'],
            ['nome' => 'Secretaria de Mobilidade Urbana', 'sigla' => 'SEMOB'],
            ['nome' => 'Secretaria de Meio Ambiente', 'sigla' => 'SEMMA'],
            ['nome' => 'Secretaria de Assistência Social', 'sigla' => 'SEMAS'],
            ['nome' => 'Secretaria da Fazenda', 'sigla' => 'SEFAZ'],
            ['nome' => 'Secretaria de Esporte, Cultura, Lazer e Juventude', 'sigla' => 'SEMEL'],
            ['nome' => 'Secretaria do Desenvolvimento da Agricultura, Abastecimento, Irrigação e Pesca', 'sigla' => 'SMDAAIP'],
            ['nome' => 'Controladoria Geral do Município', 'sigla' => 'CGM'],
            ['nome' => 'Procuradoria Geral do Município', 'sigla' => 'PGM'],
        ];

        $secretarias = [];

        foreach ($data as $item) {
            $secretarias[$item['sigla']] = Secretaria::create([...$item, 'ativo' => true]);
        }

        return $secretarias;
    }

    /**
     * @param  array<string, Secretaria>  $secretarias
     */
    private function seedDepartamentos(array $secretarias): void
    {
        $departamentos = [
            'SEMAD' => [
                ['nome' => 'Compras e Licitações', 'sigla' => 'COMPRAS'],
                ['nome' => 'Recursos Humanos', 'sigla' => 'RH'],
                ['nome' => 'Patrimônio', 'sigla' => 'PATRIM'],
                ['nome' => 'Tecnologia da Informação', 'sigla' => 'TI'],
            ],
            'SEMED' => [
                ['nome' => 'Ensino Fundamental', 'sigla' => 'EFUND'],
                ['nome' => 'Educação Infantil', 'sigla' => 'EINF'],
                ['nome' => 'Transporte Escolar', 'sigla' => 'TRESC'],
            ],
            'SEMUS' => [
                ['nome' => 'Atenção Básica', 'sigla' => 'ATBAS'],
                ['nome' => 'Vigilância Sanitária', 'sigla' => 'VISA'],
                ['nome' => 'Farmácia Municipal', 'sigla' => 'FARM'],
            ],
            'SEMOB' => [
                ['nome' => 'Engenharia', 'sigla' => 'ENG'],
                ['nome' => 'Manutenção', 'sigla' => 'MANUT'],
            ],
            'SEMMA' => [
                ['nome' => 'Fiscalização Ambiental', 'sigla' => 'FISC'],
                ['nome' => 'Licenciamento', 'sigla' => 'LIC'],
            ],
            'SEMAS' => [
                ['nome' => 'CRAS', 'sigla' => 'CRAS'],
                ['nome' => 'CREAS', 'sigla' => 'CREAS'],
                ['nome' => 'Conselho Tutelar', 'sigla' => 'CONTUT'],
            ],
            'SECULT' => [
                ['nome' => 'Eventos e Promoções', 'sigla' => 'EVENT'],
                ['nome' => 'Biblioteca Municipal', 'sigla' => 'BIBLIO'],
            ],
            'SEFAZ' => [
                ['nome' => 'Tributação', 'sigla' => 'TRIB'],
                ['nome' => 'Contabilidade', 'sigla' => 'CONT'],
                ['nome' => 'Tesouraria', 'sigla' => 'TES'],
            ],
        ];

        foreach ($departamentos as $siglaSecretaria => $deps) {
            foreach ($deps as $dep) {
                Departamento::create([
                    ...$dep,
                    'secretaria_id' => $secretarias[$siglaSecretaria]->id,
                    'ativo' => true,
                ]);
            }
        }
    }

    /**
     * @return array<string, Categoria>
     */
    private function seedCategorias(): array
    {
        $data = [
            ['nome' => 'Material de Escritório', 'descricao' => 'Papéis, canetas, pastas, grampeadores e demais materiais de expediente'],
            ['nome' => 'Material de Limpeza', 'descricao' => 'Produtos e utensílios para limpeza e higienização'],
            ['nome' => 'Equipamento de Informática', 'descricao' => 'Computadores, monitores, impressoras, periféricos e acessórios'],
            ['nome' => 'Mobiliário', 'descricao' => 'Mesas, cadeiras, armários, estantes e demais móveis'],
            ['nome' => 'Material Elétrico', 'descricao' => 'Lâmpadas, fios, disjuntores e componentes elétricos'],
            ['nome' => 'Material Hidráulico', 'descricao' => 'Tubos, conexões, torneiras e componentes hidráulicos'],
            ['nome' => 'Equipamento Médico-Hospitalar', 'descricao' => 'Equipamentos e instrumentos para uso em saúde'],
            ['nome' => 'Material Esportivo', 'descricao' => 'Bolas, redes, uniformes e equipamentos esportivos'],
            ['nome' => 'Material Didático', 'descricao' => 'Livros, apostilas, jogos educativos e materiais pedagógicos'],
        ];

        $categorias = [];

        foreach ($data as $item) {
            $categorias[$item['nome']] = Categoria::create($item);
        }

        return $categorias;
    }

    /**
     * @return array<string, UnidadeMedida>
     */
    private function seedUnidadesMedida(): array
    {
        $data = [
            ['nome' => 'Unidade', 'sigla' => 'UN'],
            ['nome' => 'Caixa', 'sigla' => 'CX'],
            ['nome' => 'Pacote', 'sigla' => 'PCT'],
            ['nome' => 'Rolo', 'sigla' => 'RL'],
            ['nome' => 'Frasco', 'sigla' => 'FL'],
            ['nome' => 'Galão', 'sigla' => 'GL'],
            ['nome' => 'Quilograma', 'sigla' => 'KG'],
            ['nome' => 'Metro', 'sigla' => 'MT'],
        ];

        $unidades = [];

        foreach ($data as $item) {
            $unidades[$item['sigla']] = UnidadeMedida::create($item);
        }

        return $unidades;
    }

    private function seedFornecedores(): void
    {
        $fornecedores = [
            [
                'nome' => 'Papelaria Central Ltda',
                'cnpj' => '12.345.678/0001-90',
                'telefone' => '(63) 3215-1234',
                'email' => 'contato@papelariacentral.com.br',
                'endereco' => 'Rua 7 de Setembro, 450',
                'cidade' => 'Palmas',
                'estado' => 'TO',
                'cep' => '77015-400',
            ],
            [
                'nome' => 'InfoTech Soluções em TI',
                'cnpj' => '23.456.789/0001-01',
                'telefone' => '(63) 3025-5678',
                'email' => 'vendas@infotechti.com.br',
                'endereco' => 'Av. JK, 1200 - Sala 305',
                'cidade' => 'Palmas',
                'estado' => 'TO',
                'cep' => '77006-218',
            ],
            [
                'nome' => 'Distribuidora Limpeza Total',
                'cnpj' => '34.567.890/0001-12',
                'telefone' => '(63) 3217-9012',
                'email' => 'comercial@limpezatotal.com.br',
                'endereco' => 'Quadra 108 Norte, Lote 15',
                'cidade' => 'Palmas',
                'estado' => 'TO',
                'cep' => '77001-126',
            ],
            [
                'nome' => 'Móveis & Escritório São José',
                'cnpj' => '45.678.901/0001-23',
                'telefone' => '(63) 3214-3456',
                'email' => 'orcamento@moveissaojose.com.br',
                'endereco' => 'Av. Teotônio Segurado, 890',
                'cidade' => 'Palmas',
                'estado' => 'TO',
                'cep' => '77019-500',
            ],
            [
                'nome' => 'Elétrica e Hidráulica Tocantins',
                'cnpj' => '56.789.012/0001-34',
                'telefone' => '(63) 3213-7890',
                'email' => 'vendas@eletricatocantins.com.br',
                'endereco' => 'Rua Joaquim Teotônio Segurado, 234',
                'cidade' => 'Palmas',
                'estado' => 'TO',
                'cep' => '77015-002',
            ],
            [
                'nome' => 'MedEquip Equipamentos Hospitalares',
                'cnpj' => '67.890.123/0001-45',
                'telefone' => '(62) 3095-1122',
                'email' => 'contato@medequip.com.br',
                'endereco' => 'Av. T-63, 1500',
                'cidade' => 'Goiânia',
                'estado' => 'GO',
                'cep' => '74250-280',
            ],
        ];

        foreach ($fornecedores as $fornecedor) {
            Fornecedor::create([...$fornecedor, 'ativo' => true]);
        }
    }

    /**
     * @param  array<string, Categoria>  $categorias
     * @param  array<string, UnidadeMedida>  $unidades
     */
    private function seedItens(array $categorias, array $unidades): void
    {
        $itens = [
            // Material de Escritório (consumo)
            ['nome' => 'Papel A4 75g (Resma 500fls)', 'categoria' => 'Material de Escritório', 'unidade' => 'PCT', 'tombamento' => false, 'minimo' => 50, 'atual' => 120],
            ['nome' => 'Caneta Esferográfica Azul', 'categoria' => 'Material de Escritório', 'unidade' => 'CX', 'tombamento' => false, 'minimo' => 20, 'atual' => 45],
            ['nome' => 'Grampeador de Mesa', 'categoria' => 'Material de Escritório', 'unidade' => 'UN', 'tombamento' => false, 'minimo' => 10, 'atual' => 25],
            ['nome' => 'Pasta Suspensa', 'categoria' => 'Material de Escritório', 'unidade' => 'CX', 'tombamento' => false, 'minimo' => 15, 'atual' => 30],

            // Material de Limpeza (consumo)
            ['nome' => 'Detergente Líquido 500ml', 'categoria' => 'Material de Limpeza', 'unidade' => 'FL', 'tombamento' => false, 'minimo' => 30, 'atual' => 80],
            ['nome' => 'Água Sanitária 5L', 'categoria' => 'Material de Limpeza', 'unidade' => 'GL', 'tombamento' => false, 'minimo' => 20, 'atual' => 40],
            ['nome' => 'Papel Higiênico (Fardo 64 rolos)', 'categoria' => 'Material de Limpeza', 'unidade' => 'RL', 'tombamento' => false, 'minimo' => 10, 'atual' => 8],

            // Equipamento de Informática (tombamento)
            ['nome' => 'Computador Desktop', 'categoria' => 'Equipamento de Informática', 'unidade' => 'UN', 'tombamento' => true, 'minimo' => 5, 'atual' => 15],
            ['nome' => 'Monitor LED 24"', 'categoria' => 'Equipamento de Informática', 'unidade' => 'UN', 'tombamento' => true, 'minimo' => 5, 'atual' => 12],
            ['nome' => 'Impressora Multifuncional', 'categoria' => 'Equipamento de Informática', 'unidade' => 'UN', 'tombamento' => true, 'minimo' => 2, 'atual' => 6],
            ['nome' => 'Notebook', 'categoria' => 'Equipamento de Informática', 'unidade' => 'UN', 'tombamento' => true, 'minimo' => 3, 'atual' => 4],

            // Mobiliário (tombamento)
            ['nome' => 'Mesa de Escritório 1,20m', 'categoria' => 'Mobiliário', 'unidade' => 'UN', 'tombamento' => true, 'minimo' => 5, 'atual' => 10],
            ['nome' => 'Cadeira Giratória com Braço', 'categoria' => 'Mobiliário', 'unidade' => 'UN', 'tombamento' => true, 'minimo' => 5, 'atual' => 18],
            ['nome' => 'Armário de Aço 2 Portas', 'categoria' => 'Mobiliário', 'unidade' => 'UN', 'tombamento' => true, 'minimo' => 3, 'atual' => 7],
            ['nome' => 'Estante de Aço 6 Prateleiras', 'categoria' => 'Mobiliário', 'unidade' => 'UN', 'tombamento' => true, 'minimo' => 3, 'atual' => 5],

            // Material Elétrico (consumo)
            ['nome' => 'Lâmpada LED Tubular T8 18W', 'categoria' => 'Material Elétrico', 'unidade' => 'UN', 'tombamento' => false, 'minimo' => 30, 'atual' => 50],
            ['nome' => 'Fio Flexível 2,5mm (Rolo 100m)', 'categoria' => 'Material Elétrico', 'unidade' => 'RL', 'tombamento' => false, 'minimo' => 5, 'atual' => 3],

            // Equipamento Médico (tombamento)
            ['nome' => 'Esfigmomanômetro Digital', 'categoria' => 'Equipamento Médico-Hospitalar', 'unidade' => 'UN', 'tombamento' => true, 'minimo' => 5, 'atual' => 10],
            ['nome' => 'Balança Antropométrica', 'categoria' => 'Equipamento Médico-Hospitalar', 'unidade' => 'UN', 'tombamento' => true, 'minimo' => 3, 'atual' => 5],
        ];

        foreach ($itens as $item) {
            Item::create([
                'nome' => $item['nome'],
                'categoria_id' => $categorias[$item['categoria']]->id,
                'unidade_medida_id' => $unidades[$item['unidade']]->id,
                'requer_tombamento' => $item['tombamento'],
                'estoque_minimo' => $item['minimo'],
                'estoque_atual' => $item['atual'],
            ]);
        }
    }
}
