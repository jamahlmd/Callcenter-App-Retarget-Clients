@extends('layouts.loggedIn')


@section('content')

    <div class="container">
        <div class="text-center">
            <p class="lead">Importeren Marketing lijst</p>
        </div>
    </div>


    <div class="container">
        <div class="col-md-12">
            <form action="{{ URL::to('import') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group text-center">
                    <label for="exampleFormControlFile1">Import Excel</label>
                    <input type="file" name="import_file" class="form-control-file" id="exampleFormControlFile1">

                    <label for="basic-url">Marketinglijst naam</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Bijv: Goji Cream 1/4 - 1/5</span>
                        </div>
                        <input type="text" class="form-control" id="basic-url" name="name" aria-describedby="basic-addon3">
                    </div>

                    <button class="btn btn-block btn-outline-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>

    @endsection