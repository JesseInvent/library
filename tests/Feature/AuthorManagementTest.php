<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
   
    public function test_an_author_can_be_created() 
    { 
        $this->withoutExceptionHandling();

        $this->post('/author', [
            'name' => 'Author Name',
            'dob' => '05/04/2021',
        ]);
        
        $author = Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
    }
    
}
 