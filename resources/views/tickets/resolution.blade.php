@extends('layouts.app')

@section('title', $ticket->title)

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
	        <div class="panel panel-default">
	        	<div class="panel-heading">
	        	{{ $ticket->title }} ({{ $ticket->ticket_id }})
	        	</div>

	        	<div class="panel-body">
	        		@include('includes.flash')
	        		
	        		
	        		<div class="comment-form">
		        		<form action="{{ route('close.ticket.post') }}" method="POST" class="form">
		        			{!! csrf_field() !!}

		        			<input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

		        			Resolution : <br>

		        			<div class="form-group{{ $errors->has('resolution') ? ' has-error' : '' }}">
                                <textarea rows="10" id="resolution" class="form-control" name="resolution"></textarea>

                                @if ($errors->has('resolution'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('resolution') }}</strong>
                                    </span>
                                @endif
	                        </div>

	                        <div class="form-group">
                                <button type="submit" class="btn btn-danger">Close Ticket</button>
	                        </div>
		        		</form>
	        	</div>
	        </div>
	    </div>
	</div>
@endsection