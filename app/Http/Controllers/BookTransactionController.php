<?php

namespace App\Http\Controllers;

use App\Book;
use App\BooksTransaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use JWTAuth;

class BookTransactionController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }


    public function rentABook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'b_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->api(false,$validator->messages(),null);
        }


        if(false == Book::find($request->b_id)){
            return response()->api(false,'Invalid book id provided',null);
        }

        //check if this book is already rented by the user or not
        $rented = BooksTransaction::findActiveRentedBookByUserId($this->user->u_id);

        if(true == $rented){
            return response()->api(false,'book is already rented to you',null);
        }

        $txn = new BooksTransaction();
        $txn->u_id = $this->user->u_id;
        $txn->b_id = $request->b_id;
        $txn->status = BooksTransaction::RENTED;
        $txn->book_rented_on = Carbon::now();
        $txn->save();

        return response()->api(true,'book rented successfully',$txn);
    }

    public function returnABook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'b_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->api(false,$validator->messages(),null);
        }


        if(false == Book::find($request->b_id)){
            return response()->api(false,'Invalid book id provided',null);
        }

        //check if this book is already rented by the user or not
        $rented = BooksTransaction::findActiveRentedBookByUserId($this->user->u_id);

        if(false == $rented){
            return response()->api(false,'book is not rented to you, can not be returned',null);
        }


        $rented->u_id = $this->user->u_id;
        $rented->b_id = $request->b_id;
        $rented->status = BooksTransaction::RETURNED;
        $rented->book_returned_on = Carbon::now();
        $rented->save();

        return response()->api(true,'book returned successfully',$rented);
    }
}
