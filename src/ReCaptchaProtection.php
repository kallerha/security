<?php

declare(strict_types=1);

namespace FluencePrototype\Security;

use Attribute;
use FluencePrototype\Http\HttpUrl;
use FluencePrototype\Http\Messages\Request\FormService;

#[Attribute(Attribute::TARGET_METHOD)]
class ReCaptchaProtection
{

    /**
     * ReCaptcha constructor.
     */
    public function __construct()
    {
        $formService = new FormService();
        $reCaptchaService = new ReCaptchaProtectionService();
        $captchaResponse = $formService->getString(name: $reCaptchaService::G_RECAPTCHA_HOSTNAME);

        if (!$captchaResponse || !$reCaptchaService->isValid(captchaResponse: $captchaResponse)) {
            $currentUrl = HttpUrl::createFromCurrentUrl();

            header(header: 'HTTP/1.1 303 See Other');
            header(header: 'Location: ' . $currentUrl);

            exit;
        }

    }

}