<?php

namespace App\Repositories\Employee;

use App\DTO\employee\CreateEmployeeDTO;
use App\DTO\employee\UpdateEmployeeDTO;
use App\Models\Employee;
use App\Models\User;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use stdClass;

class EmployeeEloquentORM implements EmployeeRepositoryInterface
{
    public function __construct(
        protected Employee $employee,
        protected User $user
    ) {
    }

    // public function getAll(string $filter = null): array
    // {
    // }
    public function findOne(string $id): stdClass
    {
        $employee = $this->employee->with(['user'])->find($id);
        if (!$employee) return null;

        return (object) $employee->toArray();
    }
    // public function delete(string $id): void
    // {
    // }
    public function create(CreateEmployeeDTO $dto): stdClass
    {
        $user = $this->user->create($dto->user);
        $employee = $this->employee->create([
            'user_id' => $user->id,
            'affiliate_id' => $dto->affiliate_id
        ]);

        return (object) $employee->toArray();
    }
    public function update(UpdateEmployeeDTO $dto): stdClass
    {

        $employee = $this->employee->find($dto->id);

        $user = $this->user->find($employee->user_id);
        $user->update($dto->user);

        $employee->update([
            'affiliate_id' => $dto->affiliate_id
        ]);

        return (object) $this->findOne((string)$dto->id);
    }
}
