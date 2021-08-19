<?php

declare(strict_types=1);

namespace FluencePrototype\Security;

use Attribute;
use FluencePrototype\Http\Messages\Request\FormService;

#[Attribute(Attribute::TARGET_METHOD)]
class ReCaptcha
{

    /**
     * ReCaptcha constructor.
     */
    public function __construct()
    {
        $formService = new FormService();

    }

}