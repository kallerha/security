<?php

declare(strict_types=1);

namespace FluencePrototype\Security;

use Attribute;
use FluencePrototype\Http\Messages\Request\FormService;
use FluencePrototype\Http\Messages\Response\StatusCodes;

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
            $currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            header(header: 'Location: ' . $currentUrl, replace: true, response_code: StatusCodes::SEE_OTHER);

            exit;
        }
    }

}