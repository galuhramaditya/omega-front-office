<?php

namespace App\Contracts;

interface RoleRepositoryInterface
{
    public function get(int $level);

    public function create(array $data);

    public function update(array $data, string $id);

    public function delete(string $id);

    public function findOneBy(array $data);

    public function pageSync(array $pages, string $id);

    public function pageDetach(string $id);
}