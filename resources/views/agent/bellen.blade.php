@extends('layouts.loggedIn')

@include('inc.loader')

@section('content')

    @foreach($klanten as $klant)

        {{$klant->name}}

    @endforeach

    @endsection