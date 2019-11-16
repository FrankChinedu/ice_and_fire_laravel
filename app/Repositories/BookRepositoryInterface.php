<?php

namespace App\Repositories;

interface BookRepositoryInterface {

  public function getAllBooks($request);

  public function create($request);

  public function update($request, $id);

  public function show($id);

  public function destroy($id);

}
