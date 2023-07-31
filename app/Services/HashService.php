<?php

namespace Storylog\Services;


class HashService
{
    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public function verifyPassword(string $value, string $hashedPassword)
    {
        return password_verify($value, $hashedPassword);
    }

    public function randomHash(int $length): string
    {
        return bin2hex(random_bytes($length));
    }
}