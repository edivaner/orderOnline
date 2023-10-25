<?php

namespace App\Services;

use App\DTO\employee\CreateEmployeeDTO;
use App\DTO\employee\UpdateEmployeeDTO;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use stdClass;

class EmployeeService
{

    public function __construct(
        protected EmployeeRepositoryInterface $repositoryEmployee
    ) {
    }

    public function store(CreateEmployeeDTO $dto): stdClass|null
    {
        $employee = $this->repositoryEmployee->create($dto);

        if (!$employee) return null;

        return $this->repositoryEmployee->findOne((string)$employee->id);
    }

    public function findOne(string $id)
    {
        return $this->repositoryEmployee->findOne($id);
    }

    public function update(UpdateEmployeeDTO $dto): stdClass
    {
        return $this->repositoryEmployee->update($dto);
    }
}
