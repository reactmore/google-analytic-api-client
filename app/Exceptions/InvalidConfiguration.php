<?php

namespace Reactmore\GoogleAnalyticApi\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function viewIdNotSpecified(): static
    {
        return new static('There was no view ID specified. You must provide a valid view ID to execute queries on Google Analytics.');
    }

    public static function credentialsJsonDoesNotExist(string $path): static
    {
        return new static("Could not find a credentials file at `{$path}`.");
    }

    public static function validateContentType($content)
    {
        if (!self::isContentTypeArray($content)) {
            throw new InvalidContentType();
        }
    }

    public static function isContentTypeArray($content)
    {
        return is_array($content);
    }
}
