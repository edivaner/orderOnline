<?php

use App\DTO\customer\CreateCustomerDTO;
use App\DTO\customer\UpdateCustomerDTO;
use App\Repositories\Customer\CustomerRepositoryInterface;

class CustomerEloquentORM implements CustomerRepositoryInterface
{
    public function getAll(string $filter = null): array
    {
    }
    public function findOne(string $id): stdClass
    {
    }
    public function delete(string $id): bool
    {
    }
    public function create(CreateCustomerDTO $dto): stdClass
    {
    }
    public function update(UpdateCustomerDTO $dto): stdClass
    {
    }
}
