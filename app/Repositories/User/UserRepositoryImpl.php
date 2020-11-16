<?php

namespace App\Repositories\User;

use App\Models\User\User;

class UserRepositoryImpl implements IUserRepository {

    public function getUsers($limit = null) 
    {
        if($limit !== null) {
            return User::with('roles')->paginate($limit);
        }
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
        $user->role = $data['role'];
        $user->save();
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
        $user->role = $data['role'];
        $user->save();
    }
    
    public function delete($id) 
    {
        User::find($id)->delete();
    }

    public function getUsersCount() {
        return count(User::all());
    }

    public function findByEmail($email) {
        return User::where('email', $email)->first();
    }
}