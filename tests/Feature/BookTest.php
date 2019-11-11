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
        $response = $this->json('POST', '/api/v1/books', [
            "name" => "a game of throne",
            "isbn" => 1234567849,
            "authors" => "lever cool, manny moo",
            "number_of_pages" => 234,
            "publisher"=> "new book haven",
            "release_date"=> "2009-12-01" 
        ]);

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
}
