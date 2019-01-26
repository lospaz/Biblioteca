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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id){
        $book = Book::query()
            ->with('category')
            ->where('id', $id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'book' => $book
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
            'success' => ((bool) $book),
            'book' => $book
        ]);
    }

    /**
     * @param CreateBook $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateBook $request, $id){
        $book = Book::findOrFail($id);
        $book->fill($request->all());
        $book->save();

        return response()->json([
            'success' => ((bool) $book),
            'book' => $book
        ]);
    }

    /**
     * @param CreateBook $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){
        $book = Book::findOrFail($id);

        if($book->loans()->count() > 0)
            return response()->json([
                'success' => false,
            ]);

        $book->delete();

        return response()->json([
            'success' => true,
        ]);
    }

}
