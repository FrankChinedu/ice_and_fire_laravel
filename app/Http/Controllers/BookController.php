<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BookRepositoryInterface;
use App\Http\Requests\BookStoreRequest;

class BookController extends Controller
{
    protected $book;

    public function __construct(BookRepositoryInterface $book)
    {
        $this->book = $book;   
    }

    public function create(BookStoreRequest $request){
        
        $res = $this->book->create($request);
        return response()->json($res, $res['status_code']);
    }

    public function getAllBooks() {
        $res = $this->book->getAllBooks();
        return response()->json($res);
    }
}
