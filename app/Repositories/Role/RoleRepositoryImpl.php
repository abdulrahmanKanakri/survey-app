<?php

namespace App\Repositories\Role;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepositoryImpl implements IRoleRepository {

    public function getRoles() {
        return Role::all();
    }
    
    public function getPermissions() {
        return Permission::all();
    }
    
    public function getRoleById($id) {
        return Role::find($id);
    }
    
    public function create($data) {
        Role::create(['name' => $data['name']])
            ->syncPermissions($data['permissions']);
    }
    
    public function update($data, $id) {
        $role = Role::find($id);
        $role->name = $data['name'];
        $role->save();
        $role->syncPermissions($data['permissions']);
    }
    
    public function delete($id) {
        Role::find($id)->delete();
    }
}