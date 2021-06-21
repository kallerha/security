<?php

declare(strict_types=1);

namespace FluencePrototype\Security;

/**
 * Class PasswordService
 * @package FluencePrototype\Security
 */
class PasswordService
{

    /**
     * @param string $password
     * @return string|null
     */
    public function hash(string $password): ?string
    {
        if ($passwordHashed = password_hash(password: $password, algo: PASSWORD_ARGON2ID)) {
            return $passwordHashed;
        }

        return null;
    }

    /**
     * @param string $passwordRaw
     * @param string $passwordHashed
     * @return bool
     */
    public function verify(string $passwordRaw, string $passwordHashed): bool
    {
        return password_verify(password: $passwordRaw, hash: $passwordHashed);
    }

}