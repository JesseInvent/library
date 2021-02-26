<?php

namespace Tests\Unit;

use App\Models\Author;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Exception;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksReservationTest extends TestCase
{
    use RefreshDatabase;
   
    public function test_a_book_can_be_checked_out ()
    {
        $book = Book::factory()->create();

        $user = User::factory()->create();

        // dd($book->id);

        $book->checkout($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }

    public function test_a_book_can_be_returned ()
    {

        $book = Book::factory()->create();
        $user = User::factory()->create();
        $book->checkout($user);

        $book->checkin($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertNotNUll(Reservation::first()->checked_in_at);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);

    }

    public function test_if_not_checked_out_exception_is_thrown() {

        $this->expectException(Exception::class);
        
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkin($user);
    }

    public function test_a_user_can_checkout_a_book_twice() {
        
        $book = Book::factory()->create();
        $user = User::factory()->create();
        
        $book->checkout($user);

        $book->checkin($user);

        $book->checkout($user);


        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::find(4)->user_id);
        $this->assertEquals($book->id, Reservation::find(4)->book_id);
        $this->assertNull(Reservation::find(4)->checked_in_at);
        $this->assertEquals(now(), Reservation::find(4)->checked_out_at); 

        $book->checkin($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::find(4)->user_id);
        $this->assertEquals($book->id, Reservation::find(4)->book_id);
        $this->assertNotNull(Reservation::find(4)->checked_in_at);
        $this->assertEquals(now(), Reservation::find(4)->checked_in_at); 
  
}
 