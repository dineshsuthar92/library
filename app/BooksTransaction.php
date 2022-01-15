<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BooksTransaction extends Model
{
    protected $table = 'books_transactions';

    //status
    const RENTED = 1;
    const RETURNED = 0;

    public static function findActiveRentedBookByUserId($u_id)
    {
        return self::where('status',self::RENTED)->where('u_id', $u_id)->first();
    }
}
