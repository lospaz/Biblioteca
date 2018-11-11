@extends('layouts.app')

@section('content')

    <div class="page-header">
        <h1 class="page-title">
            I tuoi libri presi in prestito
        </h1>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table card-table table-striped">
                <thead>
                <tr>
                    <th colspan="2">Titolo</th>
                    <th>Autore</th>
                    <th>Restituire entro</th>
                </tr>
                </thead>
                <tbody>
                @foreach($loans as $loan)
                    <tr>
                        <td class="w-1">
                            <div class="avatar d-block" style="background-image: url({{ $loan->book->getPhoto() }})"></div>
                        </td>
                        <td>{{ $loan->book->title }}</td>
                        <td>{{ $loan->book->author }}</td>
                        <td class="text-nowrap font-weight-bold">
                            {{ $loan->getRestitutionDate() }}
                            @if($loan->returned)
                                <span class="tag tag-gray">restituito</span>
                            @else
                                @if($loan->loanExpired())
                                    <span class="status-icon bg-danger"></span>
                                @else
                                    <span class="status-icon bg-success"></span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection