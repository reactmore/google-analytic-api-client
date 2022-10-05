<?php

namespace Reactmore\GoogleAnalyticApi\Helpers\Validations;

use Reactmore\GoogleAnalyticApi\Exceptions\InvalidContentType;
use Reactmore\GoogleAnalyticApi\Exceptions\MissingArguements;

class ValidationHelper
{
    public static function isContentTypeArray($content)
    {
        return is_array($content);
    }

    public static function getMissingFields($content, $fields)
    {
        return array_values(array_diff($fields, array_keys($content)));
    }

    public static function validateContentType($content)
    {
        if (!self::isContentTypeArray($content)) {
            throw new InvalidContentType();
        }
    }
    
    public static function validateContentFields($content, $fields)
    {
        $missingFields = self::getMissingFields($content, $fields);

        if (!empty($missingFields)) {
            throw new MissingArguements('Field ' . $missingFields[0] . ' is missing');
        }
    }

    public static function credentialsJsonDoesNotExist(string $path)
    {
        if (!file_exists($path)) {
            throw new MissingArguements("Could not find a credentials file at `{$path}`.");
        }
    }
}