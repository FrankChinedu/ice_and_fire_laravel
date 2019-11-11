<?php

namespace App\Repositories;


use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class BookRepository implements BookRepositoryInterface {
  
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

  }

  public function update($request, $id){

  }

  public function show($id){

  }

  public function destroy($id){

  }
}