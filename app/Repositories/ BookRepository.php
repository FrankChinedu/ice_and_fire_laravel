<?php

namespace App\Repositories;


use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Model\Book;
use App\Traits\TransformTrait;

class BookRepository implements BookRepositoryInterface {
  use TransformTrait;
  
  public function getAllBooks() {

    try {
      $books = Book::all(); // if we expeect so much request we would paginate it

      return $this->transformResponse(200, 'success', 'books data', $books);
    } catch (\Throwable $th) {
      return $this->transformResponse(500, 'error', 'an error occured', $th);
    }
  }

  public function getExternalBooks($url) {

    $client = new Client();

    try {

      $res = $client->get($url);
      $res = $res->getBody()->getContents();

      $res = json_decode($res);

      foreach ($res as $key => $value) {
        unset($value->characters);
        unset($value->povCharacters);
        unset($value->mediaType);
      }

      return $res;
    } catch (GuzzleException $th) {
      return ['messagae' => 'an error must have occurred'];
    }

  }

  public function create($request){

    try {
      
      $author = $this->changeAuthorStringToArray($request->input('authors'));

      $book = new Book();
      $book->name = $request->input('name');
      $book->isbn = $request->input('isbn');
      $book->authors = $author;
      $book->number_of_pages = $request->input('number_of_pages');
      $book->publisher = $request->input('publisher');
      $book->release_date = $request->input('release_date');

      $book->save();
      
      return $this->transformResponse(201, 'success', 'book created', $book);

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
        'authors' => $request->input('authors') ? $this->changeAuthorStringToArray($request->input('authors')) : $book->authors, 
        'number_of_pages' => $request->input('number_of_pages') ? $request->input('number_of_pages') : $book->number_of_pages, 
        'publisher' => $request->input('publisher') ? $request->input('publisher') : $book->publisher, 
        'release_date' => $request->input('release_date') ? $request->input('release_date') : $book->release_date
      ]);

      return $this->transformResponse(200, 'success', 'book updated', $book);

    } catch (\Throwable $th) {
      return $this->transformResponse(404, 'error', 'id does not exist', $th);
    }

  }

  public function show($id){

    try {
      $book = Book::find($id);
      $book = $book ? $book : [];

      return $this->transformResponse(200, 'success', 'book found', $book);
    } catch (\Throwable $th) {
      return $this->transformResponse(404, 'error', 'book notfound', $th);
    }
  }

  public function destroy($id){
    Book::find($id)->delete();

    return $this->transformResponse(204, 'success', 'book found', []);
  }

  private function changeAuthorStringToArray($str) {
    $authorsArr = [];

    $authors = explode(',', $str);

    foreach ($authors as $key => $value) {
      array_push($authorsArr, $value);
    }

    return json_encode($authorsArr);
  }
}