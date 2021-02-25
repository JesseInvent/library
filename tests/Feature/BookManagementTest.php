<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_book_can_be_added_to_library()
    {
        // $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => "Victor"
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    public function test_a_title_is_required() 
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

    }

    public function test_a_book_can_be_updated()
    {

        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool title',
            'author' => "James"
        ]); 

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New title',
            'author' => "New author"
        ]);

        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New author', Book::first()->author);

        $response->assertRedirect($book->path());

    } 

    public function test_a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool title',
            'author' => "James"
        ]); 

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertStatus(302);

        $response->assertRedirect('/books');
    }
}
