<?php

namespace Storylog\Interfaces;

use Storylog\Core\Config;

interface ViewInterface
{
    public function __construct(Config $config);
    
    public function renderLayout(string $layoutName);

    public function renderTemplate($template, $params = []);

    public function renderBaseView(string $baseView, $params = []);
    
    public function createPage(string $view, $params = []): void;

    public function addGlobals(string $key, $value): void;

    public function getGlobals(): array;
}