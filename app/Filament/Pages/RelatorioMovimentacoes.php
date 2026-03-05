<?php

namespace App\Filament\Pages;

use App\Enums\MovimentacaoTipo;
use App\Enums\NavigationGroup;
use App\Models\Movimentacao;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class RelatorioMovimentacoes extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $title = 'Movimentações por Período';

    protected static ?string $navigationLabel = 'Movimentações';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Relatorios;

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.relatorio-table';

    public function table(Table $table): Table
    {
        return $table
            ->query(Movimentacao::query()->with(['item', 'usuario']))
            ->columns([
                TextColumn::make('data')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('item.nome')
                    ->label('Item')
                    ->searchable(),
                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge(),
                TextColumn::make('quantidade')
                    ->numeric(),
                TextColumn::make('saldo_anterior')
                    ->label('Saldo Ant.')
                    ->numeric(),
                TextColumn::make('saldo_atual')
                    ->label('Saldo Atual')
                    ->numeric(),
                TextColumn::make('referencia_tipo')
                    ->label('Referência')
                    ->formatStateUsing(fn (string $state, $record): string => ucfirst($state)." #{$record->referencia_id}"),
                TextColumn::make('usuario.name')
                    ->label('Usuário')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('tipo')
                    ->options(MovimentacaoTipo::class)
                    ->label('Tipo'),
                SelectFilter::make('item_id')
                    ->relationship('item', 'nome')
                    ->label('Item')
                    ->searchable()
                    ->preload(),
                Filter::make('periodo')
                    ->form([
                        DatePicker::make('data_inicio')
                            ->label('Data Início'),
                        DatePicker::make('data_fim')
                            ->label('Data Fim'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['data_inicio'], fn (Builder $q, $date) => $q->whereDate('data', '>=', $date))
                            ->when($data['data_fim'], fn (Builder $q, $date) => $q->whereDate('data', '<=', $date));
                    }),
            ])
            ->defaultSort('data', 'desc');
    }
}
