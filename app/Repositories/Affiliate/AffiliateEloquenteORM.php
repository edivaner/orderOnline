<?php

namespace App\Repositories\Affiliate;

use App\DTO\affiliate\CreateAffiliateDTO;
use App\DTO\affiliate\UpdateAffiliateDTO;
use App\Models\Address;
use App\Models\Affiliate;
use App\Repositories\Affiliate\AffiliateRepositoryInterface;
use stdClass;

class AffiliateEloquenteORM implements AffiliateRepositoryInterface
{
    public function __construct(
        protected Affiliate $affiliate,
        protected Address $address
    ) {
    }

    // public function getAll(): stdClass
    // {
    // }

    public function findOne(string $id): stdClass
    {
        $affiliate = $this->affiliate->with(['address'])->findOrFail($id);
        return (object) $affiliate->toArray();
    }

    // public function delete(string $id): void
    // {
    // }

    public function create(CreateAffiliateDTO $dto): stdClass
    {
        $address = $this->address->create($dto->address);
        $affiliate = $this->affiliate->create([
            'name' => $dto->name,
            'telephone' => $dto->telephone,
            'head_office' => $dto->head_office,
            'address_id' => $address->id
        ]);

        return (object) $affiliate->toArray();
    }

    public function update(UpdateAffiliateDTO $dto): stdClass
    {
        $affiliate = $this->affiliate->find($dto->id);

        $address = ($affiliate->address_id) ? $this->address->find($affiliate->address_id) : null;
        if (!$address) {
            $address = $this->address->create($dto->address);
        } else {
            $address->update($dto->address);
        }

        // print_r($this->address);
        // die();

        $affiliate->update([
            'name' => $dto->name,
            'telephone' => $dto->telephone,
            'head_office' => $dto->head_office,
            'address_id' => $address->id
        ]);

        return (object) $affiliate->toArray();
    }
}
