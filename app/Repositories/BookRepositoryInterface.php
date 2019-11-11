<?php

namespace App\Repositories;

interface BookRepositoryInterface {

  public function getExternalBooks($name);

  public function getAllBooks();

  public function create($request);

  public function update($request, $id);

  public function show($id);

  public function destroy($id);

}
