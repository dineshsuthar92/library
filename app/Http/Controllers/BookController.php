<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Validator;

class BookController extends Controller
{
    public function createABook(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->all(), [
            'book_name' => 'required',
            'author' => 'required',
            'cover_image' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->api(false,$validator->messages(),null);
        }


        try {
            $book = new Book();

            $book->book_name = $request->book_name;
            $book->author = $request->author;
            $book->cover_image = $request->cover_image;

            $book->save();
        } catch (\Exception $e){
            return response()->api(false,$e->getMessage(),null);
        }

        return response()->api(true,'Book added successfully', $book);
    }

    public function editBook($book_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_name' => 'sometimes|required',
            'author' => 'sometimes|required',
            'cover_image' => 'sometimes|required'
        ]);

        if ($validator->fails()) {
            return response()->api(false,$validator->messages(),null);
        }

        $book = Book::find($book_id);

        if(false == $book)
        {
            return response()->api(false,'Invalid Book ID provided',null);
        }

        if($request->has('book_name')) {
            $book->book_name = $request->book_name;
        }

        if($request->has('author')) {
            $book->author = $request->author;
        }

        if($request->has('cover_image')) {
            $book->cover_image = $request->cover_image;
        }

        $book->save();

        return response()->api(true,'Book updated successfully', $book);
    }

    public function getBook($book_id = null)
    {
        if(false == $book_id){
            $books = Book::get();
            return response()->api(true,'Books fetched successfully', $books);
        }
        $book = Book::find($book_id);
        if(false == $book)
        {
            return response()->api(false,'Invalid Book ID provided',null);
        }

        return response()->api(true,'Book fetched successfully', $book);
    }

    public function deleteBook($book_id)
    {
        $book = Book::find($book_id);
        if(false == $book)
        {
            return response()->api(false,'Invalid Book ID provided',null);
        }

        $book->delete();
        return response()->api(true,'Book deleted successfully',null);
    }
}
