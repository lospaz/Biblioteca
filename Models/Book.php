<?php

namespace Modules\Library\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Michelangelo\ModelActivity\Traits\HasActivity;

class Book extends Model {

    use HasActivity;

    protected $fillable = ['category_id', 'title', 'author', 'isbn', 'publishedDate', 'quantity'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function loans(){
        return $this->hasMany(Loan::class);
    }

    /**
     * Get book status tag
     * @return string
     */
    public function getStatus() {
        switch ($this->available){
            case true:
                return "<span class='tag tag-green'>disponibile</span>";
            case false:
                return "<span class='tag tag-gray'>non disponibile</span>";
        }
    }

    /**
     * Get photo of book
     * @return mixed|string
     */
    public function getPhoto() {
        return ($this->photoUrl == null) ?  "https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/No_immagine_disponibile.svg/600px-No_immagine_disponibile.svg.png" : $this->photoUrl;
    }

    /**
     * Return formatted date to year only
     * @return mixed|string
     */
    public function getFormattedDate(){
        try {
            return Carbon::parse($this->publishedDate)->format('Y');
        } catch (Exception $e){
            return $this->publishedDate;
        }
    }

    /**
     * Get book availability
     * @return bool
     */
    public function isAvailable() : bool {
        $quantity = $this->quantity;
        $loans = $this->loans->where('returned', false)->count();
        return !($loans >= $quantity);
    }

    /**
     * Check if book is already loaned
     * @return bool
     */
    public function alreadyLoanedByUser($user){
        return ($user->loans->where('book_id', $this->id)->count() > 0);
    }
}
