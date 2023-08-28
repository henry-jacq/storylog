<?php

namespace Storylog\Interfaces;

use Storylog\Core\View;
use Storylog\Core\Config;

interface ViewInterface
{
    public function __construct(Config $config);

    public function renderLayout(string $layoutName, array $params);

    public function renderTemplate($template, $params = []);

    public function renderBaseView(string $baseView, $params = []);

    public function createPage(string $view, $params = [], $withFrame): View;

    public function render(): void;

    public function addGlobals(string $key, $value): void;

    public function getGlobals(): array;

    public function withFrame(array $params): View;

    public function withoutFrame(): View;
}
