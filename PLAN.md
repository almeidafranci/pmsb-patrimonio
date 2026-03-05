# Plano do Sistema Patrimonial

## Modelo de Dados Completo

### Cadastros Base
```
secretarias         → id, nome, sigla, ativo, timestamps, soft_deletes
departamentos       → id, secretaria_id, nome, sigla, ativo, timestamps, soft_deletes
categorias          → id, nome, descricao, timestamps
unidades_medida     → id, nome, sigla (UN, CX, PCT...), timestamps
fornecedores        → id, nome, cnpj, telefone, email, endereco, cidade, estado, cep, ativo, timestamps, soft_deletes
usuarios            → id, name, email, role (spatie), timestamps
```

### Itens
```
itens
  → id, categoria_id, unidade_medida_id
  → nome, descricao
  → requer_tombamento   (boolean)
  → estoque_minimo
  → estoque_atual       (atualizado via Action)
  → timestamps, soft_deletes
```

### Entradas
```
entradas
  → id, fornecedor_id, numero_nota
  → data_entrada, observacao, usuario_id
  → status (enum: rascunho | confirmada)
  → timestamps

entrada_itens
  → id, entrada_id, item_id
  → quantidade, valor_unitario
  → timestamps
```
> Ao **confirmar** a entrada (via `ConfirmarEntrada` Action): estoque sobe + movimentação registrada + tombamentos pendentes criados para itens com flag ativa.

### Patrimônio (Tombamentos)
```
tombamentos
  → id, item_id, entrada_item_id
  → numero_tombamento    (único, informado manualmente)
  → secretaria_id        (localização atual)
  → departamento_id      (localização atual)
  → valor                (decimal, do valor_unitario da entrada)
  → data_tombamento
  → status               (enum: pendente | ativo | baixado)
  → observacao, usuario_id
  → timestamps, soft_deletes
```

### Transferências Patrimoniais
```
transferencias_patrimoniais
  → id, tombamento_id
  → secretaria_origem_id, departamento_origem_id
  → secretaria_destino_id, departamento_destino_id
  → data_transferencia
  → motivo, observacao, usuario_id
  → timestamps
```
> Ao confirmar (via `RegistrarTransferencia` Action): atualiza `secretaria_id` / `departamento_id` no tombamento. O histórico fica nesta tabela.

### Baixas de Bens Tombados
```
baixas_patrimoniais
  → id, tombamento_id
  → data_baixa
  → motivo   (enum: perda | furto | obsolescencia | doacao | outro)
  → descricao, usuario_id
  → timestamps
```
> Ao confirmar (via `RegistrarBaixa` Action): status do tombamento = `baixado`.

### Requisições e Saídas
```
requisicoes
  → id, secretaria_id, departamento_id
  → data_requisicao, responsavel
  → observacao, usuario_id
  → status (enum: rascunho | confirmada)
  → timestamps

requisicao_itens          (itens de consumo)
  → id, requisicao_id, item_id
  → quantidade_solicitada, quantidade_atendida
  → timestamps

requisicao_tombamentos    (bens tombados)
  → id, requisicao_id, tombamento_id
  → timestamps
```
> Ao **confirmar** (via `ConfirmarRequisicao` Action): decrementa estoque dos itens de consumo + atualiza localização dos tombados + registra movimentações.

### Histórico de Movimentações
```
movimentacoes
  → id, item_id
  → tipo         (enum: entrada | saida)
  → quantidade, saldo_anterior, saldo_atual
  → referencia_tipo  (entrada | requisicao)
  → referencia_id
  → data             (data real da ocorrência)
  → usuario_id
  → timestamps
```

---

## Enums PHP

```
App\Enums\EntradaStatus      → Rascunho, Confirmada
App\Enums\TombamentoStatus   → Pendente, Ativo, Baixado
App\Enums\BaixaMotivo        → Perda, Furto, Obsolescencia, Doacao, Outro
App\Enums\MovimentacaoTipo   → Entrada, Saida
App\Enums\RequisicaoStatus   → Rascunho, Confirmada
```

---

## Actions (Lógica de Negócio)

```
App\Actions\ConfirmarEntrada       → incrementa estoque + movimentação + tombamentos pendentes
App\Actions\ConfirmarRequisicao    → decrementa estoque + atualiza localização + movimentação
App\Actions\RegistrarTransferencia → atualiza localização do tombamento
App\Actions\RegistrarBaixa         → marca tombamento como baixado
```

---

## Módulos Filament v5

```
Cadastros
   ├── Secretarias & Departamentos (RelationManager)
   ├── Categorias
   ├── Unidades de Medida
   ├── Fornecedores
   └── Itens (com toggle requer_tombamento)

Almoxarifado
   ├── Entradas de Material
   │    └── RelationManager: Itens da Entrada
   └── Saldo de Estoque (readonly, com badge de alerta)

Patrimônio
   ├── Tombamentos
   │    ├── RelationManager: Transferências
   │    └── RelationManager: Baixa
   ├── Transferências Patrimoniais
   └── Baixas Patrimoniais

Requisições / Saídas
   └── Requisições
        ├── RelationManager: Itens de Consumo
        └── RelationManager: Bens Tombados

Relatórios
   ├── Inventário por Secretaria/Departamento
   ├── Movimentações por Período
   ├── Bens Tombados com Localização Atual
   ├── Estoque Abaixo do Mínimo
   └── Histórico de Tombamento (por número)

Administração
   ├── Usuários
   └── Perfis e Permissões
```

---

## Roadmap por Fases

### Fase 1 — Setup e Cadastros
- [x] Laravel 12 + Filament v5 + `spatie/laravel-permission` (publicar migrations)
- [ ] PHP Enums para todos os campos de status/tipo
- [ ] Enum NavigationGroup com HasLabel/HasIcon
- [ ] Migrations de todas as tabelas base (com timestamps, soft deletes)
- [ ] Models com relacionamentos, casts e factories
- [ ] CRUDs: Secretarias, Departamentos, Categorias, Unidades, Fornecedores, Itens
- [ ] RoleAndPermissionSeeder + usuário admin
- [ ] Policies para todos os resources
- [ ] Testes dos CRUDs base

### Fase 2 — Entradas e Estoque
- [ ] Migration e Resource de `entradas` com `entrada_itens` (Repeater/RelationManager)
- [ ] `ConfirmarEntrada` Action (incrementa estoque + movimentação + tombamentos pendentes)
- [ ] Tela de Saldo de Estoque com badge visual (mínimo atingido)
- [ ] Testes do fluxo de confirmação de entrada

### Fase 3 — Tombamentos e Patrimônio
- [ ] Resource de Tombamentos com listagem de pendentes (aguardando número da etiqueta)
- [ ] Registro do `numero_tombamento` + definição de secretaria/departamento inicial
- [ ] `RegistrarTransferencia` Action + Resource dedicado
- [ ] `RegistrarBaixa` Action + Resource dedicado com enum de motivos
- [ ] Testes dos fluxos patrimoniais

### Fase 4 — Requisições e Saídas
- [ ] Resource de Requisições com dois RelationManagers (consumo + tombados)
- [ ] `ConfirmarRequisicao` Action (baixa estoque de consumo + atualiza localização dos tombados)
- [ ] Geração do **Termo de Responsabilidade** (PDF via `barryvdh/laravel-dompdf`)
- [ ] Testes do fluxo de requisição

### Fase 5 — Relatórios e Dashboard
- [ ] Dashboard: cards de totais (bens ativos, itens críticos, entradas do mês)
- [ ] 5 relatórios com filtros + exportação PDF/Excel
- [ ] Testes, ajustes de UX e validação com usuário final
