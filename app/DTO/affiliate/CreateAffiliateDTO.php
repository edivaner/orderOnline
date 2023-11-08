<?php

namespace App\DTO\affiliate;


class CreateAffiliateDTO
{
    public function __construct(
        public string $name,
        public string $telephone,
        public string $head_office,
        public array $address,
    ) {
    }

    public static function makeFromRequest($request): self
    {
        $self = new self(
            $request->name,
            $request->telephone,
            $request->head_office,
            $request->address,
        );

        return $self;
    }
}
