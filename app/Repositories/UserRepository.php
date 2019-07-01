<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function get()
    {
        return User::select("id", "username", "admin")->get();
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
        return User::select("id", "username", "admin")->where($data)->first();
    }
}