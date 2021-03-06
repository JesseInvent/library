<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker ;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
   
    public function test_an_author_can_be_created() 
    { 
        $this->withoutExceptionHandling();

        $this->post('/authors', $this->data());
        
        $author = Author::all();
        
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);

    }

    public function test_a_name_is_required () {

      $response = $this->post('/authors', array_merge($this->data(), ['name' => '']));

      $response->assertSessionHasErrors('name');
    }


    public function test_a_dob_is_required () {

        $response = $this->post('/authors', array_merge($this->data(), ['dob' => '']));

        $response->assertSessionHasErrors('dob');
    }

    private function data () {
        return [
            'name' => 'Author Name',
            'dob' => '05/04/2021',
        ];
    }
    
}
 