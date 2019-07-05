<?php

namespace App\Contracts;

interface PageRepositoryInterface
{
    public function get();

    public function create(array $data);

    public function update(array $data, string $id);

    public function delete(string $id);
}