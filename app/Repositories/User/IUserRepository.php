<?php

namespace App\Repositories\User;

interface IUserRepository {

    public function getUsers($limit = null);
    
    public function getUserById($id);
    
    public function create($data);
    
    public function update($data, $id);
    
    public function delete($id);

    public function getUsersCount();

    public function findByEmail($email);
}