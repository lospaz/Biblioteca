<?php

namespace Modules\Library\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model {

    protected $dates = ['date'];

    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getRestitutionDate(){
        return $this->date->addMonths(3)->format('d/m/Y');
    }

    public function loanExpired(){
         return ($this->date->addMonths(3)->lte(Carbon::now()));
    }
}
