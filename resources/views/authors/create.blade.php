@extends('layouts.app')

@section('content')
    <div class="w-2/3 bg-gray-200 mx-auto p-6 shadow-md">
        <form action="/authors" method="POST" class="flex flex-col items-center">
            @csrf
    
            <h1 class="font-weight-bold">Add New Author</h1>
            <div class="pt-4" >
                <input type="text" name="name" class="rounded px-4 py-2 w-64" id="" placeholder="Full name">

                @error('name')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror

            </div>
            <div class="pt-4">   
                <input type="date" name="dob" class="rounded px-4 py-2 w-64" id="" placeholder="Date of Birth">

                @error('dob')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror

            </div>
            <div class="pt-4">
                <button class="bg-blue-400 text-white rounded py-2 px-4"> Add new Author</button>
            </div>
        </form>
    </div>
@endsection