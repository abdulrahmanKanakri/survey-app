<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user-list', 'user-create', 'user-edit', 'user-delete',
            'role-list', 'role-create', 'role-edit', 'role-delete',
        ];
        
        $admin = Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        
        foreach($permissions as $name) {
            $permission = Permission::create(['name' => $name]);
            $admin->givePermissionTo($permission);
        }
        
    }
}
