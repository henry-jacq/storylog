<?php

namespace Storylog\Exception;


class NotFoundException extends \Exception
{
    protected $message = 'The page you are looking for was not found or other error occured.';
    protected $code = 404;
}
