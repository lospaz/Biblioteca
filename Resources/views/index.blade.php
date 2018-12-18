@extends('layouts.app')

@section('content')

    <div class="page-header">
        <h1 class="page-title">
            Biblioteca
        </h1>
        <div class="page-subtitle">Abbiamo {{ \Modules\Library\Models\Book::count() }} libri!</div>
        <div class="page-options d-flex">
            <form action="" method="get">
                <div class="input-icon ml-2">
                  <span class="input-icon-addon">
                    <i class="fe fe-search"></i>
                  </span>
                    <input type="text" class="form-control" style="width: 300px" value="{{ request()->q }}" name="q" placeholder="Cerca per titolo, isbn, autore...">
                </div>
            </form>
            &nbsp;
            @can('library.create')
                <a href="{{ route('library.create') }}" class="btn btn-primary"><i class="fe fe-plus"></i> Aggiungi nuovo</a>
            @endcan
        </div>
    </div>

    <div class="row row-cards row-deck">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                        <thead>
                        <tr>
                            <th class="text-center"></th>
                            <th>Libro</th>
                            <th>Autore</th>
                            <th>Pubblicazione</th>
                            <th class="text-center"><i class="icon-settings"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($books as $book)
                            <tr>
                                <td class="text-center">
                                    <div class="avatar d-block" style="background-image: url({{ $book->getPhoto() }})">
                                        <span class="avatar-status @if($book->isAvailable()) bg-green @else bg-red @endif"></span>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $book->title }}</div>
                                    <div class="small text-muted">
                                        Categoria: @if($book->category != null) {{ $book->category->name }} @endif
                                    </div>
                                </td>
                                <td>
                                    {{ $book->author }}
                                </td>
                                <td>
                                    <div class="clearfix">
                                        {{ $book->getFormattedDate() }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="item-action dropdown">
                                        <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @guest
                                                <a href="{{ route('login') }}" class="dropdown-item"><i class="dropdown-icon fe fe-log-in"></i> Accedi per prendere in prestito!</a>
                                            @endguest
                                            @auth
                                                <a href="{{ route('library.loan.index', $book->id) }}"
                                                   class="dropdown-item"><i class="dropdown-icon fe fe-hash"></i> Prendi in prestito</a>
                                                @hasrole('admin')
                                                    <a href="{{ route('library.loan.index.ext', $book->id) }}"
                                                       class="dropdown-item"><i class="dropdown-icon fe fe-user-x"></i> Prestito per persona esterna</a>
                                                @endhasrole
                                                @can('library.edit')
                                                    <a href="{{ route('library.edit', ['id' => $book->id]) }}" class="dropdown-item">
                                                        <i class="dropdown-icon fe fe-edit"></i> Modifica
                                                    </a>
                                                @endcan
                                                @can('library.delete')
                                                    <a class="dropdown-item"
                                                       href="{{ route('library.destroy', $book->id) }}"
                                                       onclick="event.preventDefault();
                                                     if(confirm('Vuoi davvero eliminare il libro?')){
                                                     document.getElementById('delete-form').submit();}">
                                                        <i class="dropdown-icon fe fe-delete"></i> Elimina
                                                    </a>
                                                    <form id="delete-form" action="{{ route('library.destroy', $book->id) }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                        @method('DELETE')
                                                    </form>
                                                @endcan
                                            @endauth
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center align-self-center">
                    {{ $books->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection