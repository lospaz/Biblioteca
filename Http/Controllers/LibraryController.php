<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Library\Http\Requests\CreateBook;
use Modules\Library\Models\Book;
use Modules\Library\Models\Category;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $books = Book::query();

        if($request->has('q')){
            $query = $request->q;
            $books->where('author', 'like', "%$query%")
                ->orWhere('title', 'like', "%$query%")
                ->orWhereHas('category', function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%");
                })
                ->orWhere('isbn', 'like', "%$query%");
        }

        return view('Library::index', [
            'books' => $books->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if(!Auth::user()->can('library.create')){
            abort(403);
        }
        return view('Library::create',[
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateBook $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBook $request) {
        if(!Auth::user()->can('library.create')){
            abort(403);
        }

        $book = new Book;
        $book->fill($request->except('_token'));

        $category = self::checkCategory($request);
        $book->category_id = $category->id;

        $book->save();

        if($book)
            flash()->success("<b>$book->title</b> salvato con successo!");

        return redirect(route('library.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if(!Auth::user()->can('library.update')){
            abort(403);
        }

        $book = Book::findOrFail($id);

        return view('Library::edit', [
            'book' => $book,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if(!Auth::user()->can('library.update')){
            abort(403);
        }
        $book = Book::findOrFail($id);
        $book->fill($request->except('_token'));
        $category = self::checkCategory($request);
        $book->category_id = $category->id;
        $book->save();

        if($book)
            flash()->success("<b>$book->title</b> modificato con successo!");

        return redirect(route('library.edit', $book->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if(!Auth::user()->can('library.delete')){
            abort(403);
        }

        $book = Book::findOrFail($id);
        $book->delete();

        flash()->warning('Libro eliminato con successo!');
        return redirect(route('library.index'));
    }

    private static function checkCategory(Request $request) {
        return (is_numeric($request->category_id))
            ? Category::find($request->category_id)
            : Category::create(['name' => $request->category_id]);
    }

}
