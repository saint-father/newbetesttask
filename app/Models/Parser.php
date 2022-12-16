<?php

namespace App\Models;

use Clue\React\Buzz\Browser;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

class Parser
{
    /**
     * @var Browser
     */
    private $client;

    /**
     * @var array
     */
    private $parsed = [];

    public function __construct(Browser $client)
    {
        $this->client = $client;
    }

    public function parse(array $urls = [], $timeout = 5)
    {
        foreach ($urls as $url) {
            $promise = $this->client->get($url)->then(
                function (ResponseInterface $response) {
                    $this->parsed[] = $this->extractFromHtml((string) $response->getBody());
                });

            $this->loop->addTimer($timeout, function() use ($promise) {
                $promise->cancel();
            });
        }
    }

    public function extractFromHtml($html)
    {
        $crawler = new Crawler($html);

        $title = trim($crawler->filter('h1')->text());
        $genres = $crawler->filter('[data-testid="genres"] span')->extract(['_text']);
        $description = trim(
            $crawler->filter('[data-testid="plot-l"]')->text()
        );

        return [
            'title'        => $title,
            'genres'       => $genres,
            'description'  => $description,
        ];
    }

    public function getMovieData()
    {
        return $this->parsed;
    }

}
