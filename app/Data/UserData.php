<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        #[Required, StringType, Email]
        public string $email,

        #[Required, StringType, Min(1)]
        public string $name,

        #[Required, StringType, Min(8)]
        public string $password,

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

        public ?string $id = null,
    ) {}
}
