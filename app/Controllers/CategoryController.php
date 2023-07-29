<?php

namespace Storylog\Controllers;

use Storylog\Core\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class CategoryController extends Controller
{
    public function category(Request $request, Response $response)
    {
        $args = [
            'title' => 'Category page',
            'categoryname' => $request->getAttribute('category'),
        ];
        return $this->render($request, $response, 'home/category', $args);
    }
}