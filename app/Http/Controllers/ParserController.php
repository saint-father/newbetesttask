<?php

namespace App\Http\Controllers;

use App\Models\Parser;
use App\Models\Task;

use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;

class ParserController extends Controller
{
    public function index()
    {
        app()->bind(LoopInterface::class, function (){
            return Loop::get();
        });

        $parser = app()->make(Parser::class);

        $parser->parse([
            'https://start.ru/watch/vampiry-sredney-polosy?utm_source=kinopoisk_special&utm_medium=cpd&utm_campaign=vampiry-sredney-polosy_2_main_ru',
            'https://start.ru/watch/franshiza-posledniy-bogatyr/season-1',
        ], 3);

        app()->call(LoopInterface::class, [], 'run');

        var_dump($parser->getMovieData());
    }
}
