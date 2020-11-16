<?php

use App\Enums\Permissions;
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
        $permissions = Permissions::getConstants();
        $roles = [
            'super-admin'
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
        $roles = Role::all();
        $roles->firstWhere('name', 'super-admin')->givePermissionTo(Permission::all());
    }
}
