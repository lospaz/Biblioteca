@extends('layouts.app')

@push('css')
<style>
    .text-divider{margin: 2em 0; line-height: 0; text-align: center;}
    .text-divider span{background-color: #ffffff; padding: 1em;}
    .text-divider:before{ content: " "; display: block; border-top: 1px solid #e3e3e3; border-bottom: 1px solid #f7f7f7;}
</style>
@endpush

@section('content')

    <div class="page-header">
        <h1 class="page-title">
            Nuovo prestito
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
            <form class="card" method="POST" action="{{ route('library.loan.store', $book->id) }}">
                @csrf
                <div class="card-body">
                    <h3 class="card-title">Compila dati</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Seleziona utente esistente</label>
                                <input type="text" class="form-control"
                                       name="user_id"
                                       id="selectUser">
                            </div>
                        </div>
                    </div>
                    <p class="text-divider"><span>o inserisci dati manualmente</span></p>
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

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/selectize.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#selectUser').selectize({
                create: false,
                placeholder: 'cerca utente...',
                valueField: 'id',
                searchField: ['name', 'surname', 'email'],
                maxItems: 1,
                render: {
                    option: function(item, escape) {
                        return '<div>' +
                            '<span class="title">' +
                            '<span class="name">' + escape(item.name) + ' ' + escape(item.surname) + '</span><br />' +
                            '</span>' +
                            '<span class="description">' + escape(item.email) + '</span>' +
                            '</div>';
                    },
                    item: function(item, escape){
                        return '<div>'
                            + escape(item.name) + ' '
                            + escape(item.surname)
                            + '</div>';
                    }
                },
                load: function(query, callback) {
                    if (!query.length) return callback();
                    $.ajax({
                        url: '{{ route('library.loan.search') }}?q=' + encodeURIComponent(query),
                        type: 'GET',
                        error: function() {
                            callback();
                        },
                        success: function(res) {
                            callback(res.users);
                        }
                    });
                }
            });
        });
    </script>
@endpush