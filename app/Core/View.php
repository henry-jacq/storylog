<?php

namespace Storylog\Core;

use Storylog\Interfaces\ViewInterface;

class View implements ViewInterface
{
    public $base_view = 'base.php';
    public string $title = 'Storylog';
    
    // Insert layouts in page
    public function renderLayout($layout_name) {
        
        if (!str_contains($layout_name, '.php')) {
            $layout = $layout_name . '.php';
        }

        $path = VIEW_PATH . '/layouts/' . $layout;

        if (file_exists($path)) {
            ob_start();
            include $path;
            $contents = ob_get_clean();
            return $contents;
        } else {
            return false;
        }
    }

    private function renderTemplate($template, $params = array())
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        if (!str_contains($template, '.php')) {
            $template = $template . '.php';
        }

        $path = VIEW_PATH . '/templates/' . $template;

        if (file_exists($path)) {
            ob_start();
            include $path;
            $contents = ob_get_clean();
            if (ob_get_length() > 0) {
                ob_end_clean();
            }
            return $contents;
        } else {
            return false;
        }
    }

    // Generates the base view
    private function renderBaseView($params = array())
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        if (isset($title)) {
            $this->title = $title;
        }

        $baseView = VIEW_PATH . DIRECTORY_SEPARATOR . $this->base_view;

        if (file_exists($baseView)) {
            ob_start();
            include $baseView;
            $contents = ob_get_clean();
            if (ob_get_length() > 0) {
                ob_end_clean();
            }
            return $contents;
        } else {
            return false;
        }
    }
    
    // Generates a page with the given template name
    public function createPage($view, $params = array())
    {
        $mainView = $this->renderBaseView($params);
        $templateView = $this->renderTemplate($view, $params);
        return str_replace('{{contents}}', $templateView, $mainView);
    }
}