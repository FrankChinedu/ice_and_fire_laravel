<?php

namespace App\Repositories;


use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Model\Book;
use App\Traits\TransformTrait;

class BookRepository implements BookRepositoryInterface {
  use TransformTrait;
  
  public function getAllBooks() {
    return ['new'];
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
      $authorsArr = [];
      
      $authors = explode(',', $request->input('authors'));

      foreach ($authors as $key => $value) {
        array_push($authorsArr, $value);
      }

      $book = new Book();
      $book->name = $request->input('name');
      $book->isbn = $request->input('isbn');
      $book->authors = json_encode($authorsArr);
      $book->number_of_pages = $request->input('number_of_pages');
      $book->publisher = $request->input('publisher');
      $book->release_date = $request->input('release_date');

      $book->save();
      
      return $this->transformResponse(201, 'success', 'book created', $book);

    } catch (\Throwable $th) {
      return $this->transformResponse(400, 'error', 'an error occured', $th);
    }
  }

  public function update($request, $id){

  }

  public function show($id){

  }

  public function destroy($id){

  }
}