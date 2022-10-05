<?php

namespace Reactmore\GoogleAnalyticApi\Exceptions;

class InvalidContentType extends BaseException
{
    public function setMessage()
    {
        return 'Content type must be array';
    }
}