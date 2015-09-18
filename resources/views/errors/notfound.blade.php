@extends('layouts.layout')

@section('title')
    Προσοχή!! η σελίδα που αναζητάτε δε βρέθηκε
@stop

@section('content')
    <div class="container">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="panel panel-default" id="error_panel">
              <div class="panel-body">
                  <div class="row">
                      <div class="col-md-5 text-center">
                        <h3>404 Πρόβλημα!</h3>
                        <h5>Προσοχή η σελίδα αυτή δεν υπάρχει</h5>
                        <h4>για να επιστρέψεις στην αρχική σελίδα πάτησε </h4>
                         <a class="btn btn-success" href="{!!URL::to('/')!!}">Αρχική</a>
                      </div>
                      <div class="col-md-7 text-center">
                          <img src="{!!asset('img/app/notfound404.png')!!}" width="50%" height="50%"/>
                      </div>
                  </div>
              </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
@stop

@section('myjquery')

@stop
