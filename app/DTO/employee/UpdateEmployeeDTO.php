<?php

namespace App\DTO\employee;


class UpdateEmployeeDTO
{
    public function __construct(
        public string $id,
        public array $user,
        public string $affiliate_id,
    ) {
    }

    public static function makeFromRequest($request, string $id = null): self
    {
        // dd($request);

        $self = new self(
            $id ?? $request->id,
            $request->user,
            $request->affiliate_id
        );

        return $self;
    }
}
