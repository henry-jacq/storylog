<?php

namespace Storylog\Core;


class Response
{
    // Set response code
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    // Redirect the response
    public function redirect($url)
    {
        header("Location: $url");
    }
}
