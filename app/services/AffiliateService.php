<?php

namespace App\Services;

use App\DTO\affiliate\CreateAffiliateDTO;
use App\DTO\affiliate\UpdateAffiliateDTO;
use App\Repositories\Affiliate\AffiliateRepositoryInterface;
use stdClass;

class AffiliateService
{

    public function __construct(
        protected AffiliateRepositoryInterface $affiliateRepository
    ) {
    }

    public function store(CreateAffiliateDTO $dto): stdClass
    {
        $affliate = $this->affiliateRepository->create($dto);

        if ($affliate)
            return $this->affiliateRepository->findOne((string)$affliate->id);
    }

    public function update(UpdateAffiliateDTO $dto): stdClass
    {
        return $this->affiliateRepository->update($dto);
    }

    public function findOne(string $id): stdClass
    {
        return $this->affiliateRepository->findOne($id);
    }
}
