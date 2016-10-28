@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    @include('includes.flash')
                    <form class="form-horizontal" role="form" method="POST" action="{{route('chngpass.post')}}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="newpass" class="col-md-4 control-label">New Passowrd</label>

                            <div class="col-md-6">
                                <input id="newpass" type="password" class="form-control" name="newpass" value="" placeholder="New Password">

                                @if ($errors->has('newpass'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('newpass') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="newpass_confirmation" class="col-md-4 control-label">Confirm Passowrd</label>

                            <div class="col-md-6">
                                <input id="newpass_confirmation" type="password" class="form-control" name="newpass_confirmation" value="" placeholder="Confirm Password">

                                @if ($errors->has('newpass_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('newpass_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Change password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
