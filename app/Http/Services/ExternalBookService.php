<?php

namespace App\Http\Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Traits\TransformTrait;


class ExternalBookService {
  use TransformTrait;

  public function getExternalBooks($url) {

    $client = new Client();

    try {

      $res = $client->get($url);
      $res = $res->getBody()->getContents();

      $res = json_decode($res);
      $data = [];

      foreach ($res as $key => $value) {

        $object = new \stdClass();
        unset($value->characters);
        unset($value->povCharacters);
        unset($value->mediaType);
        unset($value->url);

        $object->name = $value->name;
        $object->isbn = $value->isbn;
        $object->authors = $value->authors;
        $object->number_of_pages = $value->numberOfPages;
        $object->publisher = $value->publisher;
        $object->country = $value->country;
        $object->release_date = $value->released;
        array_push($data, $object);
      }

      return $this->transformResponse(200, 'success', 'External books', $data);
    } catch (GuzzleException $th) {
      return $this->transformResponse(400, 'error', 'an error occured', $th);
    }
  }

}