<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;

class UserData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $surname,
        public string $lastname,
        public string $email,
    ) {}
}
