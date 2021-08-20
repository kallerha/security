<?php

declare(strict_types=1);

namespace FluencePrototype\Security;

use FluencePrototype\Http\HttpUrl;
use FluencePrototype\Http\Messages\Request;
use ReCaptcha\ReCaptcha;

/**
 * Class ReCaptchaService
 * @package FluencePrototype\Security
 */
class ReCaptchaProtectionService
{

    public const G_RECAPTCHA_NAME = 'g-recaptcha-response';

    /**
     * @return string
     */
    public function attachToForm(): string
    {
        return '<input type="hidden" id="' . $this::G_RECAPTCHA_NAME . '" name="' . $this::G_RECAPTCHA_NAME . '">' . PHP_EOL;
    }

    /**
     * @param string $captchaResponse
     * @return bool
     */
    public function isValid(string $captchaResponse): bool
    {
        $request = new Request();

        if (!$secret = $_ENV['G_RECAPTCHA_SECRET']) {
            return false;
        }

        if (!$ip = $request->getIp()) {
            return false;
        }

        $reCaptcha = new ReCaptcha(secret: $secret);

        $response = $reCaptcha->setExpectedHostname(hostname: $_ENV['G_RECAPTCHA_HOSTNAME'])
            ->verify(response: $captchaResponse, remoteIp: $ip);

        if ($response->isSuccess() && $response->getScore() > 0.5) {
            return true;
        }

        return false;
    }

}