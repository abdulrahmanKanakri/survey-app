<?php

namespace App\Repositories\Role;

interface IRoleRepository {
    
    public function getRoles();
    
    public function getPermissions();
    
    public function getRoleById($id);
    
    public function create($data);
    
    public function update($data, $id);
    
    public function delete($id);
}