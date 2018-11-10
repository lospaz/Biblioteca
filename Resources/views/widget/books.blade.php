<div class="card">
    <div class="card-status card-status-left bg-blue"></div>
    <div class="card-header">
        <h3 class="card-title">Ultimi 5 libri</h3>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-striped">
            <thead>
            <tr>
                <th colspan="2">Titolo</th>
                <th>Autore</th>
                <th>Pubblicazione</th>
            </tr>
            </thead>
            <tbody>
            @foreach($books as $book)
                <tr>
                    <td class="w-1">
                        <div class="avatar d-block" style="background-image: url({{ $book->getPhoto() }})">
                            <span class="avatar-status @if($book->isAvailable()) bg-green @else bg-red @endif"></span>
                        </div>
                    </td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td class="text-nowrap">{{ $book->getFormattedDate() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <a href="{{ route('library.index') }}" class="btn btn-primary btn-sm">Visualizza tutti</a>
    </div>
</div>
