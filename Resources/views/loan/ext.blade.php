@extends('layouts.app')

@section('content')

    <div class="page-header">
        <h1 class="page-title">
            Prestito per altra persona
        </h1>
    </div>

    <div class="row row-cards row-deck">
        <div class="col-md-4">
            <div class="card text-center">
                <a href="#"><img class="card-img-top avatar-xl mt-1" src="{{ $book->getPhoto() }}" alt=""></a>
                <div class="card-body d-flex flex-column">
                    <div class="h6">Titolo</div>
                    <div class="display-5 font-weight-bold mb-4">{{ $book->title }}</div>
                    <div class="h6">Autore</div>
                    <div class="display-5 font-weight-bold mb-4">{{ $book->author }}</div>
                    <div class="h6">Pubblicazione</div>
                    <div class="display-5 font-weight-bold mb-4">{{ $book->getFormattedDate() }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <form class="card" method="POST" action="{{ route('library.loan.store.ext', $book->id) }}">
                @csrf
                <div class="card-body">
                    <h3 class="card-title">Compila dati</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Cognome</label>
                                <input type="text" class="form-control" name="surname">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Telefono</label>
                                <input type="text" class="form-control" name="telephone">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Prendi in prestito</button>
                </div>
            </form>
        </div>
    </div>
@endsection