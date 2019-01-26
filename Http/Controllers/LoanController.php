<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Library\Http\Requests\CreateLoan;
use Modules\Library\Models\Book;
use Modules\Library\Models\Loan;

class LoanController extends Controller {

    public function index(){
        return view('Library::loan.index', [
            'loans' => Auth::user()->loans
        ]);
    }

    public function loan($id){
        $book = Book::findOrFail($id);
        if(!$book->isAvailable() OR $book->alreadyLoanedByUser(Auth::user())){
            flash()->warning('Il libro selezionato non è attualmente disponibile!');
            return redirect(route('library.index'));
        }

        return view('Library::loan.loan', [
            'book' => $book,
            'current' => Auth::user()
        ]);
    }

    public function store(CreateLoan $request, $id){
        $book = Book::findOrFail($id);

        //Check if is available
        if(!$book->isAvailable()){
            flash()->warning('Il libro selezionato non è attualmente disponibile!');
            return redirect(route('library.index'));
        }

        $loan = new Loan;
        $loan->book_id = $book->id;
        $loan->date = Carbon::today();

        if($request->has('user_id') && $request->user_id != null){
            $user = User::find($request->user_id);
            if(!$user){
                flash()->warning('L\'utente selezionato non è stato trovato.');
                return redirect(route('library.loan.index', $book->id));
            }
            $loan->user_id = $user->id;
        } else {
            $loan->name = "{$request->name} {$request->surname}";
            $loan->telephone = $request->telephone;
        }

        $loan->save();

        if($loan)
            flash()->success("Prestito aggiunto con successo!
            La restituzione deve avvenire entro il <b>{$loan->date->addMonths(3)->format('d/m/Y')}</b>");
        else
            flash()->warning('Si è verificato un errore durante l\'aggiunta del prestito.');
        return redirect(route('library.index'));
    }

    public function search(Request $request){
        $search = $request->q;
        $users = User::where(function ($q) use ($search){
            $q->where('name', 'like', "%$search%")
                ->orWhere('surname', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('telephone', 'like', "%$search%");
        })
            ->select('id', 'name', 'surname', 'email')
            ->get();

        return response()->json([
                'success' => true,
                'users' => $users
            ]
        );
    }
}
