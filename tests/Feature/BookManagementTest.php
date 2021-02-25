<?php

namespace Tests\Feature;

use App\Models\Author;
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

    
    private function data () :array
    {
        return [
            'title' => 'Cool Book Title',
            'author_id' => "Victor"
        ];
    }

    public function test_book_can_be_added_to_library()
    {
        // $this->withoutExceptionHandling();

        $response = $this->post('/books', $this->data());

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

        $response = $this->post('/books', array_merge($this->data(), ["author_id" => '']));
        $response->assertSessionHasErrors('author_id');

    }

    public function test_a_book_can_be_updated()
    {

        $this->withoutExceptionHandling();

        $this->post('/books', $this->data()); 

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New title',
            'author_id' => "New author"
        ]);

        $this->assertEquals('New title', Book::first()->title);
        // $this->assertEquals('1', Book::first()->author_id);

        $response->assertRedirect($book->path());

    } 

    public function test_a_book_can_be_deleted()
    {
        // $this->withoutExceptionHandling();

        $this->post('/books', $this->data()); 

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertStatus(302);

        $response->assertRedirect('/books');
    }

    public function test_a_new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool title',
            'author_id' => "James"
        ]); 
  
        $book = Book::first();
        $author = Author::first();

        // dd($book->author_id);

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }
}
