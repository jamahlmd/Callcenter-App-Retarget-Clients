@extends('layouts.bellen')

@include('inc.loader')

@section('nav')
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
        <a class="btn btn-danger" href="{{ url('/bellijstkiezen/'.$id) }}">Stoppen met bellen</a>
    @endsection

@section('content')


            <div class="container-fluid pt-4 mt-4 mb-4">
                <div class="row  mt-4  text-center">
                    <div class="col-md-6">
                    <h1 class="lead">Lijst : {{$marketinglist->name}}</h1>
                    </div>
                    <div class="col-md-6">
                    <p class="lead"> Je Belt voor de {{$marketinglist->product}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mt-4">
                            <div class="card-header">
                                <div class="card-title">
                                    Klant naam : {{$klant->name}}
                                </div>
                            </div>
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Telefoon Nummer : {{$klant->telefoon}}
                                        </div>
                                        <div class="col-md-6">
                                            Mobiele Nummer : {{$klant->mobiel}}
                                        </div>
                                    </div>
                            </div>
                            <div class="card-footer">
                                <a href="/results/sale/{{$klant->id}}" class="btn btn-success btn-lg text-white">Sale</a>
                                <a href="/results/reject/{{$klant->id}}" class="btn btn-warning btn-lg text-white">Reject</a>
                                <a href="/results/frans/{{$klant->id}}" class="btn btn-info btn-lg text-white">Frans</a>
                                <a href="/results/trash/{{$klant->id}}" class="btn btn-danger btn-lg text-white">Trash</a>
                                <button data-toggle="modal" data-target="#exampleModal" class="btn btn-dark btn-lg text-white">Terugbellen</button>
                                <a href="/results/nietopgenomen/{{$klant->id}}" class="btn btn-success btn-lg text-white">Niet opgenomen</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 mb-4">
                    <div class="container">
                        <table class="table table-bordered table-active">
                            <h2>Resell Call geschiedenis</h2>
                            <thead>
                            <tr>
                                <td>Tijd & datum</td>
                            </tr>
                            </thead>
                            <tbody>
                            @if($klant->status == 5)


                                <tr>
                                    <td> {{$klant->updated_at->format('d M Y - H:i:s')}} </td>
                                </tr>


                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4 mb-4">
                    <div class="container">
                        <table class="table table-bordered table-active">
                            <h2>Retour geschiedenis</h2>
                            <thead>
                            <tr>
                                <td>Product</td>
                                <td>Reden</td>
                                <td>Datum retour</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($retouren as $retour)

                                <tr>
                                    <td> {{$retour->product_naam}} </td>
                                    <td> {{$retour->reden}} </td>
                                    <td> {{$retour->datum}} </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


    {{--MODAL--}}

            <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Terug bel afspraak maken</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('/results/afspraak/'.$klant->id) }}" method="post">

                                {{ csrf_field() }}
                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="date" data-target="#datetimepicker1"/>
                                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <br>
                                <label>
                                    Opmerking<br>
                                    <textarea name="note"></textarea>
                                </label>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Annuleer</button>
                                    <button type="submit" class="btn btn-success">Afspraak plannen!</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

    @endsection


@include('inc.footer')


@section('scripts')

            <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha18/js/tempusdominus-bootstrap-4.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha18/css/tempusdominus-bootstrap-4.min.css" />






            <script type="text/javascript">

//                $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
//                    icons: {
//                        time: 'far fa-clock'
//                    } });



                $(function () {
                    $('#datetimepicker1').datetimepicker();
                });
            </script>
@endsection