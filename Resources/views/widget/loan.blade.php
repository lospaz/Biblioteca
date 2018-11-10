@if(Auth::check())
    <div class="card">
        <div class="card-body text-center">
            <div class="h5">Libri presi in prestito</div>
            <div class="display-4 font-weight-bold mb-4">
                {{ Auth::user()->myLoans() }}
            </div>
        </div>
    </div>
@endif