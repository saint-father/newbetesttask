<?php

namespace App\Http\Controllers;

use App\Models\Parser;
use Illuminate\Http\Request;
use App\Models\Task;

use Clue\React\Buzz\Browser;
use React\EventLoop\Loop;

class ParserController extends Controller
{
    public function index()
    {
        $loop = Loop::get();
        $client = new Browser($loop);

        $parser = new Parser($client, $loop);
        $parser->parse([
            'https://start.ru/watch/vampiry-sredney-polosy?utm_source=kinopoisk_special&utm_medium=cpd&utm_campaign=vampiry-sredney-polosy_2_main_ru',
            'https://start.ru/watch/franshiza-posledniy-bogatyr/season-1',
        ], 3);

        $loop->run();
        var_dump($parser->getMovieData());
    }
}
