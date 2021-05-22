<?php

namespace App\Contracts;

interface TokenizableRepository
{
    public function tokenExists(string $token): int;
}
