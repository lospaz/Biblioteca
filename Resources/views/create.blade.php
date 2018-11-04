@extends('layouts.app')

@section('content')

    <form class="card" method="POST" action="{{ route('library.store') }}">
        @csrf
        <div class="card-body">
            <h3 class="card-title">Aggiungi nuovo libro</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">ISBN</label>
                        <div class="row gutters-xs">
                            <div class="col">
                                <input type="text" class="form-control{{ $errors->has('isbn') ? ' is-invalid' : '' }}" value="{{ old('isbn') }}"
                                       name="isbn" id="isbn" required>
                            </div>
                            <span class="col-auto">
                              <button class="btn btn-secondary" type="button" id="findBook"><i class="fe fe-search"></i> cerca ISBN</button>
                            </span>
                        </div>
                    </div>
                    @if ($errors->has('isbn'))
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ $errors->first('isbn') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Autore</label>
                        <input type="text" class="form-control{{ $errors->has('author') ? ' is-invalid' : '' }}" value="{{ old('author') }}"
                               name="author" id="author" required>
                        @if ($errors->has('author'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('author') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Titolo</label>
                        <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}"
                               name="title" id="title" required>
                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Data di pubblicazione</label>
                        <input type="text" class="form-control{{ $errors->has('publishedDate') ? ' is-invalid' : '' }}"
                               value="{{ old('publishedDate') }}"
                               name="publishedDate" id="publishedDate" required>
                        @if ($errors->has('publishedDate'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('publishedDate') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Categoria</label>
                        <select class="form-control custom-select{{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                                id="select-category" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($category->id == old('category_id')) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('category_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('category_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Numero presente</label>
                        <input type="number" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}"
                               value="{{ old('quantity', 1) }}"
                               name="quantity" id="quantity" required>
                        @if ($errors->has('quantity'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('quantity') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">Aggiungi libro</button>
        </div>
    </form>

@endsection

@push('scripts')
    <div class="modal fade" id="selectBook" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Seleziona libro</h4>
                </div>
                <div class="modal-body">
                    <div id="books"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            //Form data
            var isbn = document.getElementById('isbn');
            var titleForm = document.getElementById('title');
            var authorForm = document.getElementById('author');
            var publishedDate = document.getElementById('publishedDate');

            $('#findBook').click(function (e) {
                e.preventDefault();
                console.log("ISBN: " +  isbn);
                if(isbn.value === '') {
                    alert('Inserisci ISBN per utilizzare questa funzione.');
                    return null;
                }
                $.ajax({
                    url: "https://www.googleapis.com/books/v1/volumes?q=ISBN:"+isbn.value+"&key=AIzaSyCKR9z7z6sgUtPgw-wGVfgp6v4liIWsOFM",
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                        if(res.items.length > 0) {
                            $('#selectBook').modal('show');
                            var books = document.getElementById('books');
                            for(var i=0; i<res.items.length; i++){
                                books.innerHTML = books.innerHTML + '<div class="radio">\n' +
                                    '<label><input type="radio" id="booksList" name="booksList" value="'+i+'">'+res.items[i].volumeInfo.title+'</label>\n' +
                                    '</div>';
                            }
                            $("input[name='booksList']").change(function(){
                                //Get id
                                console.log("Valore: " + $("input[type='radio']:selected").val());
                                showItemInForm(res.items[ $("input[name='booksList']").val() ]);
                                //Reset
                                books.innerHTML = '';
                                //Hide modal
                                $('#selectBook').modal('hide');
                            });
                            return;
                        }
                        var item = res.items[0];
                        showItemInForm(item);
                    }
                });
            });

            function arrayToString(array) {
                var string = '';
                for(var i=0; i<array.length; i++){
                    if(i===array.length-1)
                        string = string + array[i];
                    else
                        string = string + array[i] + ",";
                }
                return string;
            }

            function showItemInForm(item){
                titleForm.value = item.volumeInfo.title;
                authorForm.value = arrayToString(item.volumeInfo.authors);
                publishedDate.value = item.volumeInfo.publishedDate;
            }

            $('#select-category').selectize({
                create: true
            });
        });
    </script>
@endpush