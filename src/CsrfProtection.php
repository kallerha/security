<?php

declare(strict_types=1);

namespace FluencePrototype\Security;

use Attribute;
use FluencePrototype\Http\HttpUrl;
use FluencePrototype\Http\Messages\Request\FormService;

/**
 * Class CsrfProtection
 * @package FluencePrototype\Security
 */
#[Attribute(Attribute::TARGET_METHOD)]
class CsrfProtection
{

    /**
     * CsrfProtection constructor.
     */
    public function __construct()
    {
        $formService = new FormService();
        $csrfProtectionService = new CsrfProtectionService();
        $csrfToken = $formService->getString(name: $csrfProtectionService::CSRF_NAME);

        if (!$csrfToken || !$csrfProtectionService->isValid(csrfToken: $csrfToken)) {
            $currentUrl = HttpUrl::createFromCurrentUrl();

            header(header: 'HTTP/1.1 303 See Other');
            header(header: 'Location: ' . $currentUrl);

            exit;
        }
    }

}