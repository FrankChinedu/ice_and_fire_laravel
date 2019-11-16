<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BookRepositoryInterface;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;

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

    public function getAllBooks(Request $request) {
        $res = $this->book->getAllBooks($request);
        return response()->json($res, $res['status_code']);
    }

    public function show($id) {
        $res = $this->book->show($id);
        return response()->json($res, $res['status_code']);
    }

    public function update(BookUpdateRequest $request, $id){
        $res = $this->book->update($request, $id);
        return response()->json($res, $res['status_code']);
    }

    public function delete($id) {
        $res = $this->book->destroy($id);
        return response()->json($res, $res['status_code']);
    }
}
