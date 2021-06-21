<?php

declare(strict_types=1);

namespace FluencePrototype\Security;

use Exception;
use FluencePrototype\Session\SessionService;

/**
 * Class CsrfProtectionService
 * @package FluencePrototype\Security
 */
class CsrfProtectionService
{

    const CSRF_NAME = 'csrf_token';

    private static ?string $csrfToken = null;

    private SessionService $sessionService;

    /**
     * CsrfProtectionService constructor.
     */
    public function __construct()
    {
        $this->sessionService = new SessionService();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function attachToForm(): string
    {
        if (!$this::$csrfToken) {
            $this::$csrfToken = bin2hex(string: random_bytes(length: 32));
        }

        $this->sessionService->set(name: $this::CSRF_NAME, value: $this::$csrfToken);

        return '<input type="hidden" name="' . $this::CSRF_NAME . '" value="' . $this::$csrfToken . '">' . PHP_EOL;
    }

    /**
     * @param string $csrfToken
     * @return bool
     */
    public function isValid(string $csrfToken): bool
    {
        if ($this->sessionService->isSet(name: $this::CSRF_NAME)
            && $this->sessionService->get(name: $this::CSRF_NAME) === $csrfToken) {
            return true;
        }

        return false;
    }

}