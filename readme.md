# Ice and Fire

##### A Books API.

## Prerequisites

Kindly ensure you install the following softwares

1. [Git](https://git-scm.com/)
2. [Laravel](https://laravel.com)
3. MySQL

## Getting Started

In order to get a copy of the project up and running on your local computer for development and testing purposes.
Do the following

1. Clone the repo.
2. Switch to project directory
3. Create a local `.env` file using the `.env.example` file on the root folder or by typing `cp .env.example .env` on the command line set env variables.
4. Type `composer install` to install dependencies
5. Type `php artisan serve` to start development server 
6. To test app run `phpunit` or `vendor/bin/phpunit`

## Routes (api - end points)

- GET  localhost:PORT/api/external-books?name=`a game of thrones` - get external book
- POST  localhost:PORT/api/v1/books - create a book
using the payload
```
{
    "name": "game the tin",
    "isbn": 123456789,
    "authors": "lever cool, manny moo",
    "number_of_pages": 200,
    "publisher": "new book haven",
    "release_date": "2009-12-01" 
}
```

- GET  localhost:PORT/api/v1/books - get all books
- GET  localhost:PORT/api/v1/books/:id - get a book by its ID
- PATCH  localhost:PORT/api/v1/books/:id - update a book passing update parameters
- DELETE  localhost:PORT/api/v1/books/:id - delete a book. 

