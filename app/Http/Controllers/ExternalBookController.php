<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BookRepositoryInterface;
use App\Http\Services\ExternalBookService;

class ExternalBookController extends Controller
{
    public $book;
    public $url = 'https://www.anapioficeandfire.com/api/books';

    public function __construct(BookRepositoryInterface $book)
    {
        $this->book = $book;
    }

    public function getBooks(Request $request) {
        $name = $request['name'] ? "?name=".$request['name'] : '';
        $url = $this->url."$name";

        $res = (new ExternalBookService())->getExternalBooks($url);
        return response()->json($res);
    }
}
