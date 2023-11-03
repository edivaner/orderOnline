<?php

namespace App\Repositories\Employee;

use App\DTO\employee\CreateEmployeeDTO;
use App\DTO\employee\UpdateEmployeeDTO;
use App\Models\Employee;
use App\Models\User;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use stdClass;

use function Laravel\Prompts\error;

class EmployeeEloquentORM implements EmployeeRepositoryInterface
{
    public function __construct(
        protected Employee $employee,
        protected User $user
    ) {
    }
    public function findOne(string $id): stdClass|null
    {
        $employee = $this->employee->with(['user'])->find($id);
        if (!$employee) return null;

        return (object) $employee->toArray();
    }

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

    public function getAll(): array
    {
        return $this->employee->with(['user', 'affiliate'])->get()->toArray();
    }

    public function delete(string $id): void
    {
        $employee = $this->employee->findOrFail($id);

        if ($employee) {
            $this->user->findOrFail($employee['user_id'])->delete();
            $this->employee->findOrFail($id)->delete();
        }
    }
}
