<?php


namespace App\Traits;


use App\Model\Author;

/**
 * 
 */
trait AuthorsTrait
{

  private function changeAuthorStringToArray($str)
  {
    $authorsArr = [];

    $authors = explode(',', $str);

    foreach ($authors as $key => $value) {
      array_push($authorsArr, trim($value));
    }

    return $authorsArr;
  }

  private function getAuthors($str)
  {
    $authorsArr = $this->changeAuthorStringToArray($str);

    $arr = $authorsArr;
    try {
      $authors = Author::whereIn('name', $arr)->get();
      return $authors;
    } catch (\Throwable $th) {
      return $th;
    }
  }

  private function authorsObjToArray($authors)
  {
    $arr = [];
    foreach ($authors as $key => $value) {
      array_push($arr, $value->name);
    }

    return $arr;
  }

  private function getAuthorThatDoesNotExist($authExistArr, $authStrArr)
  {
    $arr = [];
    foreach ($authStrArr as $key => $value) {
      # code...
      if (!in_array($value, $authExistArr)) {
        array_push($arr, $value);
      }
    }
    return $arr;
  }

  private function createAuthors($authorsArr)
  {
    $arr = [];

    foreach ($authorsArr as $key => $value) {
      # code...
      array_push($arr, ['name' => $value]);
    }

    $newAuth = Author::insert($arr);
    return $newAuth;
  }

  private function authorsIds($authors)
  {
    $arr = [];
    foreach ($authors as $key => $value) {
      array_push($arr, $value->id);
    }

    return $arr;
  }

  public function getAuthorsIdArr($authorsStr)
  {

    $authorsObj = $this->getAuthors($authorsStr);

    $authorObjArr = $this->authorsObjToArray($authorsObj);

    $authorsStrArr = $this->changeAuthorStringToArray($authorsStr);

    $notExsitAuth = $this->getAuthorThatDoesNotExist($authorObjArr, $authorsStrArr);

    $is_empty = empty($notExsitAuth);

    if (!$is_empty)
      $this->createAuthors($notExsitAuth);


    $allAuthors = $this->getAuthors($authorsStr);

    $idsArr = $this->authorsIds($allAuthors);

    return $idsArr;
  }
}