@extends('app')

@section('content')

    <h1 class="page-heading">Your Notices</h1>

    @if(count($notices) > 0)

        <table class="table table-striped table-bordered">
            <thead>
                <th>This Content:</th>
                <th>Accessible here:</th>
                <th>Is Infringing Upon my Work here:</th>
                <th>Notice sent:</th>
                <th>Content Removed:</th>
            </thead>

            <tbody>
                @foreach($notices as $notice)
                   <tr>
                        <td>{!! $notice->infringing_title !!}</td>
                        <td>{!! link_to($notice->infringing_link) !!}</td>
                        <td>{!! link_to($notice->original_link) !!}</td>
                        <td>{!! $notice->created_at->diffForHumans() !!}</td>
                        <td>
                            {!! Form::open(['data-remote', 'method'=>'PATCH', 'action' => ['NoticesController@update',$notice->id]]) !!}
                            <div class="form-group">
                                {!! Form::checkbox('content_removed', $notice->content_removed,$notice->content_removed,['data-click-submits-form']) !!}
                            </div>
                            {!! Form::close() !!}
                        </td>
                   </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center"> You haven't sent DMCA notices yet!</p>
    @endif
@endsection
