@extends('layouts.app')

@section('title', $ticket->title)

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
	        <div class="panel panel-default">
	        	<div class="panel-heading">
	        	Escalate - {{ $ticket->title }} ({{ $ticket->ticket_id }})
	        	</div>

	        	<div class="panel-body">
	        		@include('includes.flash')

	                @if($ticket->status !== "Closed")

	        		<div class="comment-form">
		        		<form class="form-horizontal" action="{{ route('escalate.send') }}" method="POST" class="form">
		        			{!! csrf_field() !!}

		        			<input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

		        			<div class="form-group{{ $errors->has('region') ? ' has-error' : '' }}">
                            <label for="region" class="col-md-4 control-label">Regions / Dept:</label>

                            <div class="col-md-6">
                                <select class="form-control" name="region[]" id="region" multiple="true">
                                	<?php
                                	$regions = json_decode($ticket->region, true);

                                	if(!is_array($regions))
                                		$regions = [$regions];
                                	?>

                                	@foreach($states as $state)
                                	<option 
                                		@if(in_array($state->state_id, $regions))
                                		selected = "selected"
                                		@endif
                                	 value="{{$state->state_id}}">{{$state->name}}</option>
                                	@endforeach
                                </select>

                                @if ($errors->has('region'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('region') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

	                    <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                 Escalate via SMS
                                </button>
                            </div>
                        </div>
		        		</form>
		        		@endif
	        	</div>
	        </div>
	    </div>
	</div>
@endsection