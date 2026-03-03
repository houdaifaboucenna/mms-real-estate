<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function Illuminate\Support\enum_value;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::findOrCreate(enum_value(RoleEnum::ADMIN));
        $user = Role::findOrCreate(enum_value(RoleEnum::USER));

        Permission::insert([
            ['name' => enum_value(PermissionEnum::CREATE_ARTICLES), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::EDIT_ARTICLES), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::DELETE_ARTICLES), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::VIEW_ARTICLES), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::CREATE_COMMENTS), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::DELETE_COMMENTS), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::VIEW_COMMENTS), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::CREATE_ESTATES), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::EDIT_ESTATES), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::DELETE_ESTATES), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::VIEW_ESTATES), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::CREATE_CONTACTS), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::EDIT_CONTACTS), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::DELETE_CONTACTS), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::VIEW_CONTACTS), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::EDIT_PROFILES), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::VIEW_PROFILES), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::EDIT_SETTINGS), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::VIEW_SETTINGS), 'guard_name' => 'web'],
            ['name' => enum_value(PermissionEnum::VIEW_OVERVIEW), 'guard_name' => 'web'],
        ]);

        $admin->syncPermissions(Permission::all());
    }
}
