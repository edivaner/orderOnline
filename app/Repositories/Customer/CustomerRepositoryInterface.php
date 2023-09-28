<?php

namespace App\Repositories\Customer;

use App\DTO\customer\{
    CreateCustomerDTO,
    UpdateCustomerDTO,
};

use stdClass;

class CustomerRepositoryInterface
{
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass;
    public function delete(string $id): bool;
    public function create(CreateCustomerDTO $dto): stdClass;
    public function update(UpdateCustomerDTO $dto): stdClass;
}
