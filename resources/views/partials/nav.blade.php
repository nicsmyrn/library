<nav class="navbar navbar-inverse navbar-fixed-top" id="nav" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand">Library</a>
        </div>



        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>{!! link_to_action('BooksController@index','Βιβλία') !!}</li>
                <li>{{-- link_to_action('UnpublishedController@index', 'Unpublished') --}}</li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if($user)
                    @if($user->role->slug == 'librarian')
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Admin Panel <span class="fa fa-caret-down"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#">Χρήστες
                                        <span class="fa fa-cogs pull-right"></span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{!! action('BooksController@create') !!}">Νέο βιβλίο
                                        <span class="badge pull-right">41</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Λογαριασμός
                            <span class="fa fa-caret-down"></span> &MediumSpace;
                            <span class="glyphicon glyphicon-user pull-right"></span>

                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">Προφίλ
                                <span class="fa fa-cogs pull-right"></span>
                                </a>
                            </li>

                            <li>
                                <a href="#">Μηνύματα
                                <span class="badge pull-right">41</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">Οι παραγγελίες
                                <span class="fa fa-book pull-right"></span>
                                </a>
                            </li>

                            <li>
                                <a href="#">Αγαπημένα
                                    <span class="fa fa-heart-o pull-right"></span>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{!!action('Auth\AuthController@getLogout')!!}">Αποσύνδεση
                                    <span class="fa fa-sign-out pull-right"></span>
                                </a>
                            </li>
                        </ul>
                    </li>

                @else
                    <li>
                        <a href="#loginModal" class="navbar-link" data-toggle="modal">
                            Σύνδεση &MediumSpace;
                            <span class="glyphicon glyphicon-user pull-right"></span>
                        </a>
                    </li>
                @endif

            </ul>
        </div><!-- /.navbar-collapse -->
    </div> <!-- container-fluid -->
</nav>
