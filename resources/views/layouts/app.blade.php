<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Expenses</title>

    <!-- Fonts -->

    <link rel="stylesheet" href="{{ url('css/pace-theme-minimal.css') }}">

    <script src="{{ url('js/pace.min.js') }}" type="text/javascript" charset="utf-8" async defer></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <link rel="stylesheet" href="{{ url('css/tables.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>

    <script src="https://npmcdn.com/masonry-layout@4.0/dist/masonry.pkgd.min.js"></script>

    <script>
        $(function() {
            $( ".datepicker" ).datepicker();
        });
    </script>
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout" class="background">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <!-- <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button> -->

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Expenses
                </a>

            </div>

            <div id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav">
                    <li class="svg-wrapper"><svg width=70px class="item-1" xmlns="http://www.w3.org/2000/svg"><rect width=70px height=35px class="shape"/></rect></svg><div class="text"><a href="{{ url('/home') }}">Home</a></div>
                    </li>
                    <li class="svg-wrapper"><svg width=90px class="item-2" xmlns="http://www.w3.org/2000/svg"><rect width=70px height=35px class="shape"/></rect></svg><div class="text"><a href="{{ url('/product/home') }}">Products</a></div>
                    </li>
                    <li class="svg-wrapper"><svg width=90px class="item-3" xmlns="http://www.w3.org/2000/svg"><rect width=70px height=35px class="shape"/></rect></svg><div class="text"><a href="{{ url('/add-user') }}">Add User</a></div>
                    </li>
                    <li class="svg-wrapper"><svg width=120px class="item-4" xmlns="http://www.w3.org/2000/svg"><rect width=70px height=35px class="shape"/></rect></svg><div class="text"><a href="{{ url('/user-list') }}">Manage Users</a></div>
                    </li>
                    <li class="svg-wrapper"><svg width=115px class="item-5" xmlns="http://www.w3.org/2000/svg"><rect width=70px height=35px class="shape"/></rect></svg><div class="text"><a href="{{ url('/create-group') }}">Create Group</a></div>
                    </li>
                    <li class="svg-wrapper"><svg width=130px class="item-6" xmlns="http://www.w3.org/2000/svg"><rect width=70px height=35px class="shape"/></rect></svg><div class="text"><a href="{{ url('/manage-group') }}">Manage Groups</a></div>
                    </li>
                    @if (Auth::guest())
                        <li class="svg-wrapper"><svg width=70px class="item-7" xmlns="http://www.w3.org/2000/svg"><rect width=70px height=35px class="shape"/></rect></svg><div class="text"><a href="{{ url('/login') }}">Login</a></div>
                        </li>
                    @else
                        <li class="username1 drop">
                            {{ Auth::user()->name }} <span class="caret"></span>
                            <ul>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                    <li><div class="inputbox"><input type="text" id="search" required="required"/> <button type="reset" class="del"></button></div></li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <script src="{{ url('js/ajax.js') }}" type="text/javascript" charset="utf-8" async defer></script>
    <script src="{{ url('js/element.js') }}" type="text/javascript" charset="utf-8" async defer></script>
    <script src="{{ url('js/modal.js') }}" type="text/javascript" charset="utf-8" async defer></script>
    <script src="{{ url('js/panel.js') }}" type="text/javascript" charset="utf-8" async defer></script>
    <script src="{{ url('js/custom.js') }}" type="text/javascript" charset="utf-8" async defer></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</body>
</html>
