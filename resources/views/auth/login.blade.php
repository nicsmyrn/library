@extends('frontend.app')

@section('title')
    Σύνδεση στο σύστημα
@stop

@section('content')

    @include('errors.list')

    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <div class="jumbotron">
                {!! Form::open(array('class' => 'form-signin', 'role'=>'form')) !!}
                    <h2 class="form-signin-heading">Είσοδος Χρήστη</h2>
                    <div class="form-group">
                        {!!Form::label('email', 'Όνομα Χρήστη:', array('class'=>'sr-only'))!!}
                        {!!Form::text('email', Input::old('username'),array('placeholder'=>'E-mail', 'class'=>'form-control'))!!}
                    </div>

                    <div class="form-group">
                        {!!Form::label('password', 'Κωδικός:', array('class'=>'sr-only'))!!}
                        {!!Form::password('password',array('placeholder'=>'password', 'class'=>'form-control'))!!}
                    </div>
                    <div class="form-group">
                        {!!Form::checkbox('rememberme','on',false)!!}
                        {!!Form::label('rememberme', 'Να με θυμάσαι')!!}
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary btn-block">Είσοδος</button>
                {!!Form::close()!!}
                </div>

            </div>


            <div class="col-md-4">
                <div class="jumbotron">
                    <h3>Σύνδεση με:</h3>
                    <div class="btn-group">
                        <a class="btn btn-block btn-social btn-facebook" href="#">
                            <i class="fa fa-facebook"></i> Facebook
                        </a>
                        <a class="btn btn-block btn-social btn-google-plus" href="#">
                            <i class="fa fa-google-plus"></i>Google
                        </a>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <label>ή</label>
                            <a href="#" class="btn btn-primary btn-lg"> Νέα εγγραφή</a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <br>

@stop
