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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{ url('css/tables.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>

    <script src="https://npmcdn.com/masonry-layout@4.0/dist/masonry.pkgd.min.js"></script>

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
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
                    <li><a href="{{ url('/home') }}">Home</a></li>
                    <li><a href="{{ url('/product/home') }}">Products</a></li>
                    <li><a href="{{ url('/add-user') }}">Add User</a></li>
                    <li><a href="{{ url('/user-list') }}">Manage Users</a></li>
                    <li><a href="{{ url('/create-group') }}">Create Group</a></li>
                    <li><a href="{{ url('/manage-group') }}">Manage Groups</a></li>
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                    @else
                        <li class="username1 drop">
                            {{ Auth::user()->name }} <span class="caret"></span>
                            <ul>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
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
