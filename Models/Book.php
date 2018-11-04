<?php

namespace Modules\Library\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Michelangelo\ModelActivity\Traits\HasActivity;

class Book extends Model {

    use HasActivity;

    protected $fillable = ['category_id', 'title', 'author', 'isbn', 'publishedDate', 'quantity'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getStatus() {
        switch ($this->available){
            case true:
                return "<span class='tag tag-green'>disponibile</span>";
            case false:
                return "<span class='tag tag-gray'>non disponibile</span>";
        }
    }

    public function getPhoto() {
        return ($this->photoUrl == null) ?  "https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/No_immagine_disponibile.svg/600px-No_immagine_disponibile.svg.png" : $this->photoUrl;
    }

    public function getFormattedDate(){
        try {
            return Carbon::parse($this->publishedDate)->format('Y');
        } catch (Exception $e){
            return $this->publishedDate;
        }
    }
}
