<?php

namespace App\Repositories\Employee;

use App\DTO\employee\CreateEmployeeDTO;
use App\DTO\employee\UpdateEmployeeDTO;
use stdClass;


interface EmployeeRepositoryInterface
{
    public function getAll(): array;
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): void;
    public function create(CreateEmployeeDTO $dto): stdClass;
    public function update(UpdateEmployeeDTO $dto): stdClass;
}
