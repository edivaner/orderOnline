<?php

namespace App\DTO\customer;


class CreateCustomerDTO
{
    public function __construct(
        public string $telephone,
        public array $user,
        public array $adress,
    ) {
    }

    public static function makeFromRequest($request)
    {
        return new self(
            $request->user,
            $request->address,
            $request->telephone
        );
    }
}
