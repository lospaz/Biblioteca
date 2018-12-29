<?php

namespace Modules\Library\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Library\Http\Requests\CreateBook;
use Modules\Library\Models\Book;
use Modules\Library\Traits\BookTrait;

class BookController extends Controller {

    use BookTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $books = Book::query()
            ->with('category');

        $books = $books->paginate(20);
        return response()->json([
            'success' => true,
            'can' => self::permission(),
            'books' => $books
        ]);
    }

    /**
     * @param CreateBook $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateBook $request){
        $book = new Book;
        $book->fill($request->all());
        $book->save();

        return response()->json([
            'success' => ((bool) $book)
        ]);
    }

}
