<?php

namespace Storylog\Services;


class HashService
{
    /**
     * Verify hashed password with given value
     */
    public function check(string $value, string $hashedPassword)
    {
        return password_verify($value, $hashedPassword);
    }

    /**
     * Return hashed version of plain password
     */
    public function make(string $password, $cost = 12): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => $cost]);
    }
    
    /**
     * Generates random string
     */
    public function randomString(int $length): string
    {
        return bin2hex(random_bytes($length));
    }

    /**
     * Return MD5 hash of given value
     */
    public function toMD5(string $value, $state = false)
    {
        return md5(string: $value, binary: $state);
    }

    /**
     * Verify the value with given md5 hash
     */
    public function checkMD5(string $value, string $hashedValue): bool
    {
        return md5($value) === $hashedValue;
    }

    /**
     * Return info about given hashed password
     */
    public function info(string $hashedValue)
    {
        return password_get_info($hashedValue);
    }
}