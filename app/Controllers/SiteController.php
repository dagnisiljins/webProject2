<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ExchangeRate;
use App\Models\Article;
use Twig\Environment;
use Carbon\Carbon;

class SiteController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function index()
    {
        $articles = [
            new Article('Title 1', 'Pirmā article apraksts', 1),
            new Article('Title 2', 'Otrā article apraksts', 2),
            new Article('Title 3', 'Trešā article apraksts', 3)
        ];

        $url = 'http://api.exchangeratesapi.io/v1/latest?access_key=4755858ee8f52d30b1b91c8d9c04a098';
        $data = json_decode(file_get_contents($url));
        $convertRequest = [
            new ExchangeRate($data->rates->USD),
            new ExchangeRate($data->rates->PLN),
            new ExchangeRate($data->rates->GBP),
            new ExchangeRate($data->rates->CAD)
        ];

        $currentTime = Carbon::now();
        $template = $this->twig->load('index.twig');

        return $template->render(['articles' => $articles, 'currentTime' => $currentTime, 'convertRequest' => $convertRequest]);
    }

    public function article($vars)
    {
        $id = $vars['id'];
        $articles = [
            1 => new Article(
                'Article 1',
                'Article description',
                1),
            2 => new Article(
                'Article 2',
                'Article description',
                2),
            3 => new Article('Title 3', 'Article description', 3)
        ];

        if (isset($articles[$id])) {
            $article = $articles[$id];
            $template = $this->twig->load('article.twig');
            return $template->render(['article' => $article]);
        } else {
            return 'Article not found';
        }
    }
}
