<?php

namespace App\DTO\affiliate;


class UpdateAffiliateDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $telephone,
        public string $head_office,
        public array $address,
    ) {
    }

    public static function makeFromRequest($request, string $id = null): self
    {
        $self = new self(
            $id ?? $request->id,
            $request->name,
            $request->telephone,
            $request->head_office,
            $request->address,
        );

        return $self;
    }
}
