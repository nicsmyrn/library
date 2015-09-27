@extends('admin.dashboard')

@section('header')
    Προβολή Χρηστών
@endsection

@section('content')
<div class="btn-group">
    @if($status = Request::get('status'))
        @if($status == 'active')
           <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Ενεργοί
        @elseif($status=='blocked')
           <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Ανενεργοί
        @elseif($status=='unregistered')
           <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Υπό έγκριση
        @else
           <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Όλοι
        @endif
    @else
   <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Όλοι
    @endif
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="{!! action('Admin\UserController@index') !!}">Όλοι</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="{!! action('Admin\UserController@index') !!}?status=active"><span class="label label-success">ενεργοί</span></a></li>
    <li><a href="{!! action('Admin\UserController@index') !!}?status=blocked"><span class="label label-danger">Ανενεργοί</span> </a></li>
    <li><a href="{!! action('Admin\UserController@index') !!}?status=unregistered"><span class="label label-warning">Υπό έγκριση</span> </a></li>
  </ul>
</div>

    <hr>
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Επώνυμο</th>
                <th>Όνομα</th>
                <th>Username</th>
                <th>Τύπος</th>
                @unless($status)<th>Κατάσταση</th>@endunless
                <th>Ενέργειες</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    @if($user->status == 'unregistered')
                        <td>{!! $user->last_name !!}</td>
                    @else
                        <td>{!! link_to_action('Admin\UserController@show',$user->last_name,[$user->hash]) !!}</td>
                    @endif
                    <td>{!! $user->first_name !!}</td>
                    <td>{!! $user->username !!}</td>
                    <td>{!! $user->role_name !!}</td>
                    @unless($status)
                        @if($user->status == 'active')
                             <td class="text-center"><span class="label label-success">ενεργός</span> </td>
                        @elseif($user->status == 'blocked')
                             <td class="text-center"><span class="label label-danger">ανενεργός</span> </td>
                        @elseif($user->status == 'unregistered')
                             <td class="text-center"><span class="label label-warning">υπό έγκριση</span> </td>
                        @else
                            <td></td>
                        @endif
                    @endunless
                    <td>
                        {!! Form::open(['method'=>'POST', 'action' => 'Admin\UserController@updateTableActions', 'data-remote']) !!}
                            @unless($user->status == 'unregistered')
                                <a class="btn btn-warning btn-xs" href="{!! action('Admin\UserController@edit', [$user->hash]) !!}" title="Επεξεργασία"><i class="glyphicon glyphicon-cog"></i> </a>
                            @endunless
                            <button type="button" title="Διαγραφή" data-click="delete" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> </button>
                            @if($user->status == 'unregistered')
                                <button type="button" title="Έγκριση" data-click="publish" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-ok"></i> </button>
                            @endif
                                {!!Form::hidden('user-hash', $user->hash)!!}
                        {!! Form::close() !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts.footer')
    @include('admin.users.index_footer')
@endsection