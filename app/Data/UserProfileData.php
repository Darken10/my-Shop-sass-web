<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class UserProfileData extends Data
{
    public function __construct(
        #[Nullable, StringType]
        public ?string $first_name = null,

        #[Nullable, StringType]
        public ?string $last_name = null,

        #[Nullable, StringType]
        public ?string $phone = null,

        #[Nullable, StringType]
        public ?string $country = null,

        #[Nullable, StringType]
        public ?string $city = null,

        #[Nullable, StringType]
        public ?string $address = null,
    ) {}
}
