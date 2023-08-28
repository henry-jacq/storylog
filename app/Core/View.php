<?php

namespace Storylog\Core;

use Exception;
use Storylog\Interfaces\ViewInterface;

class View implements ViewInterface
{
    public string $title;
    public string $baseView;
    private array $globals = [];
    private mixed $resultView;
    private string $headerBlock;
    private string $footerBlock;
    
    public function __construct(private readonly Config $config)
    {
        $this->baseView = 'base.php';
        $this->headerBlock = '{{header}}';
        $this->footerBlock = '{{footer}}';
        $this->title = $config->get('app.name');
    }

    /**
     * Generates the layout view
     */
    public function renderLayout(string $layoutName, array $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        
        if (!str_contains($layoutName, '.php')) {
            $layoutName = $layoutName . '.php';
        }

        $path = VIEW_PATH . '/layouts/' . $layoutName;

        if (file_exists($path)) {
            ob_start();
            include $path;
            $contents = ob_get_clean();
            return $contents;
        } else {
            return false;
        }
    }

    /**
     * Generates the template view
     */
    public function renderTemplate($template, $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        if (!str_contains($template, '.php')) {
            $template = $template . '.php';
        }

        // Inserting global variables
        foreach ($this->globals as $key => $value) {
            $$key = $value;
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

    /**
     * Generates the base view
     */
    public function renderBaseView(string $baseView, $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        if (isset($title)) {
            $this->title = $title;
        }

        $baseView = VIEW_PATH . DIRECTORY_SEPARATOR . $this->baseView;

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

    /**
     * Creates a page with the template name and params
     */
    public function createPage(string $view, $params = [], $withFrame = true): View
    {
        if (!str_contains($this->baseView ,'.php')) {
            $this->baseView = $this->baseView . '.php';
        }
        $mainView = $this->renderBaseView($this->baseView, $params);
        $templateView = $this->renderTemplate($view, $params);
        $this->resultView = str_replace('{{contents}}', $templateView, $mainView);
        if ($withFrame) {
            $this->withFrame($params);
        } else {
            $this->withoutFrame();
        }
        return $this;
    }

    /**
     * Render the page
     */
    public function render(): void
    {
        echo($this->resultView);
    }

    /**
     * Add global variables
     */
    public function addGlobals(string $key, $value): void
    {
        if (!array_key_exists($key, $this->globals)) {
            $this->globals[$key] = $value;
        }
    }

    /**
     * Return the saved globals
     */
    public function getGlobals(): array
    {
        if (null !== $this->globals) {
            return $this->globals;
        }

        return [];
    }

    /**
     * Render page with header and footer
     * 
     * It is a custom implementation, you can modify this with your needs.
     */
    public function withFrame(array $params): View
    {
        if (null == $this->resultView) {
            throw new Exception('Page is not rendered');
        }
        
        $baseView = $this->resultView;
        $header = str_replace($this->headerBlock, $this->renderLayout('header', $params), $baseView);
        $result = str_replace($this->footerBlock, $this->renderLayout('footer'), $header);

        $this->resultView = $result;
        
        return $this;
    }

    /**
     * Render page without header and footer
     * 
     * It is a custom implementation, you can modify this with your needs.
     */
    public function withoutFrame(): View
    {
        if (null == $this->resultView) {
            throw new Exception('Page is not rendered');
        }

        $baseView = $this->resultView;
        $header = str_replace($this->headerBlock, '', $baseView);
        $result = str_replace($this->footerBlock, '', $header);

        $this->resultView = $result;

        return $this;
    } 
}
