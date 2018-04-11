@extends('layouts.bellen')

@include('inc.loader')

@section('nav')
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
        <a class="btn btn-danger" href="{{ url('/bellijstkiezen/'.$id) }}">Stoppen met bellen</a>
    @endsection

@section('content')


{{dd($klant)}}

    @endsection


@include('inc.footer')