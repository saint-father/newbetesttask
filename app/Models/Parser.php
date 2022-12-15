<?php

namespace App\Models;

use Clue\React\Buzz\Browser;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\LoopInterface;
use Symfony\Component\DomCrawler\Crawler;

class Parser
{
    /** @var Browser */
    private $client;

    /** @var LoopInterface */
    private $loop;

    /** @var array */
    private $parsed = [];

    /**
     * Parser constructor
     *
     * @param Browser $client
     * @param LoopInterface $loop
     */
    public function __construct(Browser $client, LoopInterface $loop)
    {
        $this->client = $client;
        $this->loop = $loop;
    }

    /**
     * Prepare "promise" as a Browser content parsing result with time-limit of execution
     *
     * @param array $urls
     * @param $timeout
     * @return void
     */
    public function parse(array $urls = [], int $timeout = 5)
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

    /**
     * Web-page content parsing by Crawler features
     *
     * @param $html
     * @return array
     */
    public function extractFromHtml($html)
    {
        $crawler = new Crawler($html);

        $title = trim($crawler->filter('h1')->text());
        $genres = $crawler->filter('span span a')->extract(['_text']);
        $release = Arr::pull($genres, 0);
        $description = trim(
            $crawler->filter('[class^="Description_product__description-text"]')->text()
        );

        return [
            'title'         => $title,
            'genres'        => $genres,
            'description'   => $description,
            'release'       => $release,
        ];
    }

    /**
     * Parsing result getter
     *
     * @return array
     */
    public function getMovieData()
    {
        return $this->parsed;
    }
}
