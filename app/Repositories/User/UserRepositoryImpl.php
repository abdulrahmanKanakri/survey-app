<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepositoryImpl implements IUserRepository {

    public function getUsers() 
    {
        return User::with('roles')->get();
    }

    public function getUserById($id) 
    {
        return User::with('roles')->find($id);
    }

    public function create($data) 
    {
        $user = new User;
        $user->name     = $data['name'];
        $user->email    = $data['email'];
        $user->ip       = $data['ip'] ?? null;
        $user->password = \Hash::make($data['password'] ?? '123hamadi');
        if($data['phone_number'] ?? false) {
            $user->phone_number = $data['phone_number'];
        }
        $user->save();
        $user->assignRole($data['role'] ?? 'user');
        return $user;
    }

    public function update($data, $id) 
    {
        $user = User::find($id);
        $user->name = $data['name'];
        if($user->email != $data['email']) {
            $user->email = $data['email'];
        }
        if($data['password']) {
            $user->password = \Hash::make($data['password']);
        }
        $user->save();
        $user->syncRoles([$data['role']]);
    }
    
    public function delete($id) 
    {
        User::find($id)->delete();
    }

    public function getUsersCount() {
        return count(User::all());
    }

    public function getUsersNotAdmin() {
        return User::whereHas('roles', function ($q) {
            return $q->where('name', '!=', 'admin');
        })->get();
    }
    
    public function findByEmail($email) {
        return User::where('email', $email)->first();
    }
}