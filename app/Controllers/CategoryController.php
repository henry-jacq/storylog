<?php

namespace Storylog\Controllers;

use Storylog\Core\Controller;
use Storylog\Core\Application;


class CategoryController extends Controller
{
    public function category()
    {
        $categoryName = Application::$app->request->getRouteParam('categoryname');
        return $this->render('home/category', [
            'title' => 'Category page',
            'categoryname' => $categoryName
        ]);
    }
}