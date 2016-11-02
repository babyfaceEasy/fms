@extends('layouts.app')

@section('title', 'Reports List')

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
	        <div class="panel panel-default">
	        	<div class="panel-heading">
	        		<i class="fa fa-ticket">Reports</i>
	        	</div>

	        	<div class="panel-body">
		        		<table class="table">
		        			<tr>
		        				<td style="background-color: #eee">Transmission</td>
		        				<td>
		        					<a href="{{route('report.test', ['t', 'o'])}}" class="btn btn-danger">Open Tickets</a>
		        					
		        					<a href="#" class="btn btn-success">Closed Tickets</a>
		        				</td>
		        			</tr>

		        			<tr>
		        				<td style="background-color: #eee">Base Station Switch</td>
		        				<td>
		        					<a href="#" class="btn btn-danger">Open Tickets</a>
		        					
		        					<a href="#" class="btn btn-success">Closed Tickets</a>
		        				</td>
		        			</tr>

		        			<tr>
		        				<td style="background-color: #eee">IP Network</td>
		        				<td>
		        					<a href="#" class="btn btn-danger">Open Tickets</a>
		        					
		        					<a href="#" class="btn btn-success">Closed Tickets</a>
		        				</td>
		        			</tr>
		        		</table>
	        	</div>
	        </div>
	    </div>
	</div>
@endsection