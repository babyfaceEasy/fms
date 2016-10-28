@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if(isset($info) && $info == true)
                <div class="alert alert-info" role="alert">
                    <strong>Heads Up ! </strong>You need to change your password. Do that here <a href="{{route('chngpass.get')}}" class="alert-link">Change password.</a>
                </div>
            @endif
            <div class="panel panel-default">
                
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <p>Welcome {{Auth::user()->name}}</p>

                    @if (Auth::user()->is_admin)
                        <p>
                            See all <a href="{{ url('admin/tickets') }}">tickets</a>
                        </p>
                    @else
                        <p>
                            See all your  <a href="{{ url('my_tickets') }}">trouble tickets</a> or <a href="{{ url('new_ticket') }}">open new trouble ticket</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
