<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanCreateBook()
    {
        $data = [
            "name" => "a game of throne",
            "isbn" => 1234567849,
            "authors" => "lever cool, manny moo",
            "number_of_pages" => 234,
            "publisher" => "new book haven",
            "release_date" => "2009-12-01"
        ];
        $response = $this->json('POST', '/api/v1/books', $data);

        $response->assertStatus(201);
        $response->assertJson(['status_code' => 201]);
        $response->assertJson(['data' => ["name" => "a game of throne"]]);
        $response->assertJsonStructure([
           "status_code",
            "status",
            "message",
            "data" => [
                "name",
                "isbn",
                "authors",
                "number_of_pages",
                "publisher",
                "release_date"
            ]
        ]);
    }
    public function testCannotCreateBookIfallRequestAreNotSent()
    {
        $response = $this->json('POST', '/api/v1/books');

        $response->assertStatus(422);
        $response->assertJsonStructure([
            "errors" => [
                "name",
                "isbn",
                "authors",
                "number_of_pages",
                "publisher",
                "release_date"
            ]
        ]);
    }

    public function testUserCanGetAllBooks(){
        $data = [
            "name" => "a game of throne",
            "isbn" => 1234567849,
            "authors" => "lever cool, manny moo",
            "number_of_pages" => 234,
            "publisher" => "new book haven",
            "release_date" => "2009-12-01"
        ];

        $this->json('POST', '/api/v1/books', $data);
        $response = $this->json('get', '/api/v1/books');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "status_code",
            "status",
            "message",
            "data"
        ]);
    }

    public function testUserCanGetASpecificBook(){
        $data = [
            "name" => "a game of throne",
            "isbn" => 1234567849,
            "authors" => "lever cool, manny moo",
            "number_of_pages" => 234,
            "publisher" => "new book haven",
            "release_date" => "2009-12-01"
        ];

        $book = $this->json('POST', '/api/v1/books', $data);
        $book_id = $book->getData()->data->id;

        $response = $this->json('get', "/api/v1/books/$book_id");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "status_code",
            "status",
            "message",
            "data"
        ]);
    }

    public function testShouldReturnDataIfBookDoesNotExist(){
       
        $book_id = 14637673;

        $response = $this->json('get', "/api/v1/books/$book_id");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "status_code",
            "status",
            "message",
            "data"
        ]);
    }

    public function testUserCanUpdateBook(){
        $data = [
            "name" => "a game of throne",
            "isbn" => 1234567849,
            "authors" => "lever cool, manny moo",
            "number_of_pages" => 234,
            "publisher" => "new book haven",
            "release_date" => "2009-12-01"
        ];

        $book = $this->json('POST', '/api/v1/books', $data);
        $book_id = $book->getData()->data->id;
       
        $response = $this->json('patch', "/api/v1/books/$book_id", [
            "name" => "a range",
            "number_of_pages" => 256,
            "publisher" => "new book haven now",
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "status_code",
            "status",
            "message",
            "data"
        ]);
    }

    public function testUserCanDeleteABook(){
        $data = [
            "name" => "a game of throne",
            "isbn" => 1234567849,
            "authors" => "lever cool, manny moo",
            "number_of_pages" => 234,
            "publisher" => "new book haven",
            "release_date" => "2009-12-01"
        ];

        $book = $this->json('POST', '/api/v1/books', $data);
        $book_id = $book->getData()->data->id;
       
        $response = $this->json('delete', "/api/v1/books/$book_id");

        $response->assertStatus(204);
    }
}
