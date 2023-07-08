<?php

namespace App\Core;

/**
 * Render a view file
 */
class View
{
    /**
     * Load the layout view
     */
    public static function renderLayout(string $layout)
    {
        $layout = APP_ROOT . "/views/layouts/$layout.php";
        if (is_file($layout)) {
            include_once $layout;
        } else {
            self::loadErrorPage();
        }
    }

    /**
     * Load the template view
     */
    public static function renderTemplate(string $template)
    {
        $template = APP_ROOT . "/views/$template.php";
        if (is_file($template)) {
            include_once $template;
        } else {
            self::loadErrorPage();
        }
    }
    
    /**
     * Loads the 404 error page
     */
    public static function loadErrorPage()
    {
        http_response_code(404);
        self::renderLayout('error');
    }

    /**
     * Loads the master template
     */
    public static function renderPage()
    {
        self::renderLayout('master');
    }
}
