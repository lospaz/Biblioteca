@if($loans != null)
    <div class="card">
        <div class="card-body text-center">
            <div class="h5">Libri presi in prestito</div>
            <div class="display-4 font-weight-bold mb-4">
                @if($loans > 0) <a href="{{ route('library.loan') }}" style="text-decoration: none;"> @endif
                    {{ $loans }}
                @if($loans > 0) </a> @endif
            </div>
        </div>
    </div>
@endif