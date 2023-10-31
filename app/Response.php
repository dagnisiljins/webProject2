<?php

declare(strict_types=1);

namespace App;

use Twig\Environment;

class Response
{
    private string $viewName;
    private array $data;
    private Environment $twig;

    public function __construct(Environment $twig, string $viewName, array $data)
    {
        $this->twig = $twig;
        $this->viewName = $viewName;
        $this->data = $data;
    }

    public function render()
    {
        $template = $this->twig->load($this->viewName);
        return $template->render($this->data);
    }
}