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
    public function __construct(string $subdomain = '')
    {
        $formService = new FormService();
        $reCaptchaProtectionService = new ReCaptchaProtectionService();
        $captchaResponse = $formService->getString(name: $reCaptchaProtectionService::G_RECAPTCHA_NAME);

        if (!$captchaResponse || !$reCaptchaProtectionService->isValid(captchaResponse: $captchaResponse, subdomain: $subdomain)) {
            $currentUrl = HttpUrl::createFromCurrentUrl();

            header(header: 'HTTP/1.1 303 See Other');
            header(header: 'Location: ' . $currentUrl);

            exit;
        }

    }

}