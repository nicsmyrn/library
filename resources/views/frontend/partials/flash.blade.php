        @if(Session::has('flash_notification'))
            @if(Session::has('flash_notification.overlay'))
                <p> display modal</p>
            @else
                 <div class="alert alert-{!! Session::get('flash_notification.level') !!}">
                     {!! session('flash_notification.message') !!}
                     @if(Session::has('flash_message_important'))
                         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     @endif
                 </div>
            @endif

        @endif