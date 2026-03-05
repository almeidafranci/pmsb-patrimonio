<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $modules = [
            'secretaria',
            'departamento',
            'categoria',
            'unidade_medida',
            'fornecedor',
            'item',
            'entrada',
            'tombamento',
            'transferencia',
            'baixa',
            'requisicao',
            'movimentacao',
            'usuario',
        ];

        $actions = ['view_any', 'view', 'create', 'update', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::findOrCreate("{$action}_{$module}");
            }
        }

        Permission::findOrCreate('confirmar_entrada');
        Permission::findOrCreate('confirmar_requisicao');
        Permission::findOrCreate('registrar_transferencia');
        Permission::findOrCreate('registrar_baixa');

        $admin = Role::findOrCreate('admin');
        $admin->givePermissionTo(Permission::all());

        $almoxarife = Role::findOrCreate('almoxarife');
        $almoxarife->givePermissionTo(
            Permission::where('name', 'like', '%_item')
                ->orWhere('name', 'like', '%_entrada')
                ->orWhere('name', 'like', '%_movimentacao')
                ->orWhere('name', 'like', '%_requisicao')
                ->orWhere('name', 'like', '%_fornecedor')
                ->orWhere('name', 'like', '%_categoria')
                ->orWhere('name', 'like', '%_unidade_medida')
                ->orWhere('name', 'confirmar_entrada')
                ->orWhere('name', 'confirmar_requisicao')
                ->get()
        );

        $patrimonio = Role::findOrCreate('patrimonio');
        $patrimonio->givePermissionTo(
            Permission::where('name', 'like', '%_tombamento')
                ->orWhere('name', 'like', '%_transferencia')
                ->orWhere('name', 'like', '%_baixa')
                ->orWhere('name', 'like', '%_secretaria')
                ->orWhere('name', 'like', '%_departamento')
                ->orWhere('name', 'registrar_transferencia')
                ->orWhere('name', 'registrar_baixa')
                ->get()
        );

        $consulta = Role::findOrCreate('consulta');
        $consulta->givePermissionTo(
            Permission::where('name', 'like', 'view_any_%')
                ->orWhere('name', 'like', 'view_%')
                ->get()
        );
    }
}
