<?php

namespace Modules\Library\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model {

    protected $dates = ['date'];

    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
