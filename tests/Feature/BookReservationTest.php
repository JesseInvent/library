<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testBookCanBeAddedToLibrary()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => "Victor"
        ]);
        $response->assertOK();
        $this->assertCount(1, Book::all());
    }

    public function testATitleIsRequired() 
    {

        $response = $this->post('/books', [
            'title' => '',
            'author' => "Victor"
        ]);
        $response->assertSessionHasErrors('title');
        // $this->assertCount(1, Book::all());  
    
    }

    public function test_an_author_is_required() 
    {

        $response = $this->post('/books', [
            'title' => 'Cool title',
            'author' => ""
        ]);
        $response->assertSessionHasErrors('author');
        // $this->assertCount(1, Book::all());  
    }

    public function test_a_book_can_be_updated()
    {

        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool title',
            'author' => "James"
        ]); 

        $book = Book::first();

        $this->patch("/books/{$book->id}", [
            'title' => 'New title',
            'author' => "New author"
        ]);

        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New author', Book::first()->author);

    }
}
