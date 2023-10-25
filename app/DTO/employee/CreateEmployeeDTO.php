<?php

namespace App\DTO\employee;


class CreateEmployeeDTO
{
    public function __construct(
        public array $user,
        public string $affiliate_id,
    ) {
    }

    public static function makeFromRequest($request): self
    {
        // dd($request);

        $self = new self(
            $request->user,
            $request->affiliate_id
        );

        return $self;
    }
}
