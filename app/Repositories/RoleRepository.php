<?php

namespace App\Repositories;

use App\Contracts\RoleRepositoryInterface;
use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function get(int $level)
    {
        $roles = Role::where("level", ">=", $level)->get();

        $data = [];
        foreach ($roles as $role) {
            $data[$role->id]["id"] = $role->id;
            $data[$role->id]["name"] = $role->name;
            $data[$role->id]["level"] = $role->level;
            $data[$role->id]["pages"] = [];
            foreach ($role->pages as $page) {
                $data[$role->id]["pages"][$page->id] = $page;
            }
        }
        return $data;
    }

    public function create(array $data)
    {
        return Role::create($data);
    }

    public function update(array $data, string $id)
    {
        return Role::find($id)->update($data);
    }

    public function delete(string $id)
    {
        return Role::find($id)->delete();
    }

    public function findOneBy(array $data)
    {
        return Role::where($data)->first();
    }

    public function pageSync(array $pages, string $id)
    {
        return Role::find($id)->pages()->sync($pages);
    }

    public function pageDetach(string $id)
    {
        return Role::find($id)->pages()->detach();
    }
}