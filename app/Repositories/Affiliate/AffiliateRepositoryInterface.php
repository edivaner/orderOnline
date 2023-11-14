<?php

namespace App\Repositories\Affiliate;

use App\DTO\affiliate\CreateAffiliateDTO;
use App\DTO\affiliate\UpdateAffiliateDTO;
use stdClass;

interface AffiliateRepositoryInterface
{
    // public function getAll(): stdClass;
    public function findOne(string $id): stdClass;
    // public function delete(string $id): void;
    public function create(CreateAffiliateDTO $dto): stdClass;
    public function update(UpdateAffiliateDTO $dto): stdClass;
}
