<?php

namespace App\Hasher;

interface PasswordHashInterface
{
    public function hash(string $plainPassword): string;
}