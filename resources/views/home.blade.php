@extends('layouts.loggedIn')

@section('loader')
    @include('inc.loader')
@endsection

@section('content')


    @teamleider
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-default">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        Maak een keuze in het keuze Menu
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-danger"> Uw account heeft geen rechten</h3>
                </div>
            </div>
        </div>
        @endteamleider

@endsection
