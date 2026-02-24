<?php

namespace App\Repositories\Eloquent;

use App\Models\ModelUsers;
use App\Repositories\Interfaces\UsersInterface;

class UsersRepository implements UsersInterface
{
    public function getAllUsers()
    {
        $users = ModelUsers::all();

        return $users;
    }

    public function getUserById($id)
    {
        $user = ModelUsers::find($id);

        return !$user ? null : $user;
    }

    public function createUser(array $data)
    {
        $user = ModelUsers::create($data);

        return $user;
    }

    public function updateUser($id, array $data)
    {
        $user = ModelUsers::find($id);

        if (!$user) {
            return null;
        }

        $user->update($data);

        return $user;
    }

    public function deleteUser($id)
    {
        $user = ModelUsers::find($id);

        if (!$user) {
            return null;
        }

        $user->delete();

        return true;
    }
}