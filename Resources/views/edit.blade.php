@extends('layouts.app')

@section('content')

    <form class="card" method="POST" action="{{ route('library.update', $book->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <h3 class="card-title">Modifica libro</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">ISBN</label>
                        <div class="row gutters-xs">
                            <div class="col">
                                <input type="text" class="form-control" name="isbn" id="isbn" value="{{ $book->isbn }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Autore</label>
                        <input type="text" class="form-control" name="author" id="author" value="{{ $book->author }}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Titolo</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ $book->title }}" required>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Data di pubblicazione</label>
                        <input type="text" class="form-control" name="publishedDate" id="publishedDate" value="{{ $book->publishedDate }}" required>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Categoria</label>
                        <select class="form-control custom-select" id="select-category" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($category->id == $book->category->id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Numero presente</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" value="{{ $book->quantity }}" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">Modifica libro</button>
        </div>
    </form>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#select-category').selectize({
            create: true
        });
    });
</script>
@endpush