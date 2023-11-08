<?php

namespace App\Repositories\Affiliate;

use App\DTO\affiliate\CreateAffiliateDTO;
use stdClass;

interface AffiliateRepositoryInterface
{
    // public function getAll(): stdClass;
    public function findOne(string $id): stdClass;
    // public function delete(string $id): void;
    public function create(CreateAffiliateDTO $dto): stdClass;
    // public function update($dto): stdClass;
}
