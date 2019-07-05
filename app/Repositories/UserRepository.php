<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function get(int $level)
    {
        $users = User::whereHas("role", function ($query) use ($level) {
            $query->where("level", ">=", $level);
        })->get();

        foreach ($users as $user) {
            $user->role;
        }

        return $users;
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(array $data, string $id)
    {
        return User::find($id)->update($data);
    }

    public function delete(string $id)
    {
        return User::find($id)->delete();
    }

    public function findOneBy(array $data)
    {
        $user = User::where($data)->first();
        if ($user) {
            if ($user->role) {
                $user->role->pages;
            }
        }

        return $user;
    }
}