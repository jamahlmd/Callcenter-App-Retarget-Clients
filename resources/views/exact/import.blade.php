@extends('layouts.loggedIn')



@section('content')

    <div class="container">
        <div class="text-center">
            <p class="lead">Importeer klanten in Hubspot</p>
        </div>
    </div>


    <div class="container">
        <div class="col-md-12">
            <form action="{{ URL::to('exact/hubspot') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group text-center">
                    <label for="exampleFormControlFile1">Import Excel</label>
                    <input type="file" name="import_file" class="form-control-file" id="exampleFormControlFile1">

                    <button class="btn btn-block btn-outline-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>



    <a href="{{ url('/download') }}" class="btn btn-block btn-outline-danger">Download a neef</a>

    @endsection