@if(Auth::guest())
<div id="loginModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="text-center"><img src="{!! asset('img/app/icon-user-default.png') !!}" class="img-circle" width="30%" height="30%"><br>Σύνδεση</h2>
            </div>
            <div class="modal-body">

                {!! Form::open(['method' => 'POST', 'action' => 'Auth\AuthController@postLogin', 'class' => 'form col-md-12 center-block']) !!}
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i> </span>
                            <input type="text" class="form-control input-lg" name="email" placeholder="Email ή όνομα χρήστη">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key fa-fw"></i> </span>
                            <input type="password" class="form-control input-lg" name="password" placeholder="Κωδικός">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-lg btn-block">Σύνδεση</button>
                    </div>
                {!! Form::close() !!}

            </div>
            <div class="modal-footer">
                <div class="text-center"> <small>Σύνδεση με:</small>
                    <a class="btn btn-social-icon btn-facebook" href="#">
                        <i class="fa fa-facebook"></i>
                    </a>

                    <a class="btn btn-social-icon btn-google-plus" href="#">
                        <i class="fa fa-google-plus"></i>
                    </a>
                    <small> ή κάντε
                        <a href="{!!action('Auth\AuthController@getRegister')!!}">Εγγραφή</a>
                    </small>
                </div>
                <div class="col-md-12">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Επιστροφή</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
