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

        $parser = new Parser($client);
        $parser->parse([
            'http://www.imdb.com/title/tt1270797/',
            'http://www.imdb.com/title/tt2527336/'
        ], 3);

        $loop->run();
        var_dump($parser->getMovieData());
    }
}
