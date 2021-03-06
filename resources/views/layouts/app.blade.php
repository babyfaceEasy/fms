<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - FMS Network Operation Center</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- datatables -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
  <link href="css/app.css" rel="stylesheet">

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
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                  <div alt="Brand">  <!--<img alt="Brand" src="/images/logo.gif" height="30px">--> Fault Management System Network Operation Center</div>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <!--<li><a href="{{ url('/register') }}">Register</a></li>-->
                    @else
                        @if (Auth::user()->is_admin)

                            <li class="dropdown">
                                <a href="{{ url('admin/tickets') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Tickets 
                                <span class="caret"></span></a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('all_tickets') }}">All Tickets</a></li>
                                    <li><a href="{{ url('my_tickets') }}">My Trouble Tickets</a></li>
                                    <li><a href="{{ url('new_ticket') }}">Open Trouble Ticket</a></li>
                                </ul>

                            </li>
                            <li><a href="{{ url('new_sms') }}">Escalation via SMS</a></li>

                            <li class="dropdown">
                                <a href="{{ url('admin/tickets') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Reports 
                                <span class="caret"></span></a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ route('report.index') }}">Download Reports</a></li>
                                    <!--<li><a href="{{ url('reports') }}">All Reports</a></li>-->
                                </ul>
                            </li>
                            
                            <li><a href="{{ url('createaccount') }}">Add New Staff</a></li>
                        @else

                          <li class="dropdown">
                                <a href="{{ url('admin/tickets') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Tickets 
                                <span class="caret"></span></a>

                                <ul class="dropdown-menu" role="menu">
                                     <li><a href="{{ url('all_tickets') }}">All Tickets</a></li>
                                     <li><a href="{{ url('my_tickets') }}">My Trouble Tickets</a></li>
                                    <li><a href="{{ url('new_ticket') }}">Open Trouble Ticket</a></li>
                                </ul>

                            </li>
                          <!--<li><a href="{{ url('/createaccount') }}">Create Account</a></li>-->
                          
                          <li><a href="{{ url('new_sms') }}">Escalation via SMS</a></li>
                          <li><a href="{{ url('download_report') }}">Download Reports</a></li>
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
     <!-- DataTables -->
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="js/app.js"></script>

    <!-- App Scripts -->
    @stack('scripts')
</body>
</html>
