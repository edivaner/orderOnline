<?php

namespace App\DTO\customer;



class UpdateCustomerDTO
{
    public function __construct(
        public string $id,
        public string $telephone,
        public array $user,
        public array $adress,
    ) {
    }

    public static function makeFromRequest($request)
    {
        return new self(
            $$request->id,
            $$request->user,
            $request->address,
            $request->telephone
        );
    }
}
