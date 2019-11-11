<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BookRepositoryInterface;

class BookController extends Controller
{
    protected $book;

    public function __construct(BookRepositoryInterface $book)
    {
        $this->book = $book;   
    }

    public function create(Request $request){

    }

    public function getAllBooks() {
        $res = $this->book->getAllBooks();
        return response()->json($res);
    }
}
