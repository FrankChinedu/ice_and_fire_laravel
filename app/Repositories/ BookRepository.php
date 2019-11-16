<?php

namespace App\Repositories;

use App\Model\Book;
use App\Traits\TransformTrait;
use App\Traits\AuthorsTrait;
use App\Http\Resources\BookResource;

class BookRepository implements BookRepositoryInterface {
  use TransformTrait;
  use AuthorsTrait;
  
  public function getAllBooks($request) {
    $search = $request->get('search');

    try {
      if ($search) {
        $books = Book::where('name', 'like', "%$search%")
        ->orWhere('country', 'like', "%$search%")
        ->orWhere('publisher', 'like', "%$search%")
        ->orWhereYear('release_date', 'like', "%$search%")
        ->get();
      } else {
        $books = Book::all();
      }
      
      $message = !count($books) ? 'empty book store try adding some books' : count($books)." books found";
      return $this->transformResponse(200, 'success', $message, BookResource::collection($books));

    } catch (\Exception $th) {
      return $this->transformResponse(500, 'error', 'an error occured', $th);
    }
  }

  
  public function create($request){

    try {

      $arrId = $this->getAuthorsIdArr($request->input('authors'));

      $book = new Book();
      $book->name = $request->input('name');
      $book->isbn = $request->input('isbn');
      $book->number_of_pages = $request->input('number_of_pages');
      $book->publisher = $request->input('publisher');
      $book->country = $request->input('country');
      $book->release_date = $request->input('release_date');

      $book->save();

      $book->authors()->attach($arrId);

      return $this->transformResponse(201, 'success', 'book created', new BookResource($book));

    } catch (\Throwable $th) {
      return $this->transformResponse(500, 'error', 'an error occured', $th);
    }
  }

  public function update($request, $id){
    try {
      $book = Book::find($id);

      if(!$book) throw new \Exception("Book does not exist", 1);
      
      $book->update([
        'name' => $request->input('name') ? $request->input('name') : $book->name,
        'number_of_pages' => $request->input('number_of_pages') ? $request->input('number_of_pages') : $book->number_of_pages, 
        'publisher' => $request->input('publisher') ? $request->input('publisher') : $book->publisher,
        'isbn' => $request->input('isbn') ? $request->input('isbn') : $book->isbn,
        'country' => $request->input('country') ? $request->input('country') : $book->country,
        'release_date' => $request->input('release_date') ? $request->input('release_date') : $book->release_date
      ]);

      $authors = $request->input('authors');

      if($authors) {
        $book->authors()->detach();

        $arrId = $this->getAuthorsIdArr($authors);

        $book->authors()->attach($arrId);
      }

      return $this->transformResponse(200, 'success', 'book updated',  new BookResource($book));

    } catch (\Throwable $th) {
      return $this->transformResponse(404, 'error', 'id does not exist', $th);
    }

  }

  public function show($id){

    try {
      $book = Book::findorfail($id);
      $book = $book ? $book : [];

      return $this->transformResponse(200, 'success', 'book found',  new BookResource($book));
    } catch (\Throwable $th) {
      return $this->transformResponse(404, 'error', 'book notfound', []);
    }
  }

  public function destroy($id){

    try {

      $book = Book::findorfail($id);
      $book->authors()->detach();
      $book->delete();

      return $this->transformResponse(204, 'success', 'book found', []);
     } catch (\Exception $th) {
      return $this->transformResponse(404, 'error', 'book not found', $th);
    }
  }

}