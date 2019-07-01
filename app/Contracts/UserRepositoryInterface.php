<?php 

namespace App\Contracts;

interface UserRepositoryInterface
{
    public function get();

    public function create(array $data);

    public function update(array $data, string $id);

    public function findOneBy(array $data);

    public function delete(string $id);
}