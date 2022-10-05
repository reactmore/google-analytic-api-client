<?php

namespace Reactmore\GoogleAnalyticApi\Helpers\Validations;

class Validator
{
    public static function validateCredentialRequest($request)
    {
        ValidationHelper::validateContentType($request);
    }
}
