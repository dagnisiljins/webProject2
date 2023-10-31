<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ExchangeRate;
use App\Models\Article;
use Twig\Environment;
use Carbon\Carbon;
use App\Response;

class SiteController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    private function createArticle($id)
    {
        $articlesData = [
            1 => [
                'title' => 'Article 1',
                'description' => 'Article description',
            ],
            2 => [
                'title' => 'Article 2',
                'description' => 'Article description',
            ],
            3 => [
                'title' => 'Title 3',
                'description' => 'Article description',
            ],
        ];

        if (isset($articlesData[$id])) {
            $data = $articlesData[$id];
            return new Article($data['title'], $data['description'], $id);
        }

        return null;
    }
    public function index()
    {
        $articles = [
            $this->createArticle(1),
            $this->createArticle(2),
            $this->createArticle(3)
        ];

        $url = 'http://api.exchangeratesapi.io/v1/latest?access_key=4755858ee8f52d30b1b91c8d9c04a098';
        $data = json_decode(file_get_contents($url));
        $convertRequest = [
            new ExchangeRate($data->rates->USD),
            new ExchangeRate($data->rates->PLN),
            new ExchangeRate($data->rates->GBP),
            new ExchangeRate($data->rates->CAD)
        ];

        $currentTime = Carbon::now("Europe/Riga");

        return new Response($this->twig, 'index.twig', [
            'articles' => $articles,
            'currentTime' => $currentTime,
            'convertRequest' => $convertRequest,
        ]);
    }

    public function article($vars)
    {
        $id = (int)$vars['id'];
        $article = $this->createArticle($id);

        return new Response($this->twig, 'article.twig', ['article' => $article]);
    }
}
