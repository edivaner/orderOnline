<?php

namespace App\Repositories\Customer;

use App\DTO\customer\CreateCustomerDTO;
use App\DTO\customer\UpdateCustomerDTO;
use App\Models\Address;
use App\Models\Customer;
use App\Models\User;
use App\Repositories\Customer\CustomerRepositoryInterface;
use stdClass;

class CustomerEloquentORM implements CustomerRepositoryInterface
{
    public function __construct(
        protected Customer $customer,
        protected User $user,
        protected Address $address
    ) {
    }

    public function getAll(string $filter = null): array
    {
        return $this->customer
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('id', $filter);
                }
            })
            ->with(['address', 'user'])
            ->get()
            ->toArray();
    }

    public function findOne(string $id): stdClass
    {
        $customer = $this->customer->with(['address', 'user'])->find($id);
        if (!$customer) return null;
        return (object) $customer->toArray();
    }

    public function delete(string $id): void
    {
        $this->customer->findOrFail($id)->delete;
    }

    public function create(CreateCustomerDTO $dto): stdClass
    {
        $user = $this->user->create((array)$dto->user);
        $address = $this->address->create((array)$dto->address);

        $customer = $this->customer->create([
            'user_id'       => $user->id,
            'address_id'    => $address->id,
            'telephone'     => $dto->telephone
        ]);

        return (object) $customer->toArray();
    }

    public function update(UpdateCustomerDTO $dto): stdClass
    {
        if (!$customer = $this->customer->find($dto->id)) {
            return null;
        }

        $customer->update(
            (array) $dto
        );

        return (object) $customer->toArray();
    }
}
