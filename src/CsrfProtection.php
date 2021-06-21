<?php

declare(strict_types=1);

namespace FluencePrototype\Security;

use Attribute;
use FluencePrototype\Http\Messages\Request\FormService;
use FluencePrototype\Http\Messages\Response\RedirectionService;

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
            $redirectionService = new RedirectionService();
            $redirectionService->redirectToCurrentPage(responseCode: $redirectionService::HTTP_SEE_OTHER);
        }
    }

}