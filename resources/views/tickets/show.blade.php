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
	        		
	        		<div class="ticket-info clear-fix">
	        			<p>{{ $ticket->message }}</p>
		        		<p>Categry: {{ $category->name }}</p>
		        		<p>
	        			@if ($ticket->status === 'Open')
    						Status: <span class="label label-success">{{ $ticket->status }}</span>
    					@else
    						Status: <span class="label label-danger">{{ $ticket->status }}</span>
    					@endif
		        		</p>
		        		<p>Created on: {{ $ticket->created_at->diffForHumans() }}</p>

		        		@if( $ticket->status === "Open" && (Auth::user()->role === "ns" || Auth::user()->role === "na"))
		        		<p class="">
		        			<a href="{{route('close.ticket', $ticket->id)}}" class="btn  btn-danger">
		        				Close Ticket
		        			</a>
		        		</p>
		        		@endif

		        		<div class="clear-fix"></div>
	        		</div>

	        		<hr>

	        		<div class="comments">
	        			@foreach ($comments as $comment)
	        				<div class="panel panel-@if($ticket->user->id === $comment->user_id){{"default"}}@else{{"success"}}@endif">
	        					<div class="panel panel-heading">
	        						{{ $comment->user->name }}
	        						<span class="pull-right">{{ $comment->created_at->format('Y-m-d') }}</span>
	        					</div>

	        					<div class="panel panel-body">
	        						{{ $comment->comment }}		
	        					</div>
	        				</div>
	        			@endforeach
	        		</div>

	        		@if($ticket->status === "Closed")
	        		<div class="resolution">
	        			<p class="alert alert-success">
	        				{{$ticket->resolution}}
	        				<br/>

	        				<i style="font-size: 12px; ">
	        				<?php
	        				echo date("F jS, Y", strtotime($ticket->updated_at));
	        				?>
	        				</i>
	        				
	        			</p>
	        		</div>
	        		@endif

	        		<hr>
	                <hr>

	                @if($ticket->status !== "Closed")

	        		<div class="comment-form">
		        		<form action="{{ url('comment') }}" method="POST" class="form">
		        			{!! csrf_field() !!}

		        			<input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

		        			<div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                <textarea rows="10" id="comment" class="form-control" name="comment"></textarea>

                                @if ($errors->has('comment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                @endif
	                        </div>

	                        <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add update</button>
	                        </div>
		        		</form>
		        		@endif
	        	</div>
	        </div>
	    </div>
	</div>
@endsection