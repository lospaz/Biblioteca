<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Library\Models\Book;
use Modules\Library\Models\Loan;

class LoanController extends Controller {

    public function index($id){
        $book = Book::findOrFail($id);
        if(!$book->isAvailable()){
            flash()->warning('Il libro selezionato non è attualmente disponibile!');
            return redirect(route('library.index'));
        }

        return view('Library::loan.index', [
            'book' => $book,
            'current' => Auth::user()
        ]);
    }

    public function store(Request $request, $id){
        $book = Book::findOrFail($id);
        $user = Auth::user();
        //Check if is available
        if(!$book->isAvailable()){
            flash()->warning('Il libro selezionato non è attualmente disponibile!');
            return redirect(route('library.index'));
        }
        //Check if telephone is missing
        if($user->telephone == null && (!$request->has('telephone') OR $request->telephone == null)){
            flash()->warning('Nessun numero di telefono collegato al tuo account, specificane uno');
            return redirect(route('library.loan.index', $book->id));
        } else {
            $user->telephone = $request->telephone;
            $user->save();
        }

        $loan = new Loan;
        $loan->book_id = $book->id;
        $loan->user_id = $user->id;
        $loan->date = Carbon::today();
        $loan->save();

        if($loan)
            flash()->success("Prestito aggiunto con successo!
            La restituzione deve avvenire entro il <b>{$loan->date->addMonths(3)->format('d/m/Y')}</b>");
        else
            flash()->warning('Si è verificato un errore durante l\'aggiunta del prestito.');
        return redirect(route('library.index'));
    }

}
