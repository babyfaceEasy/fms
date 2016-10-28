@extends('layouts.app')

@section('title', 'Escalate via SMS')

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
	        <div class="panel panel-default">
	        	<div class="panel-heading">
	        		<i class="fa fa-ticket">Open Tickets</i>
	        	</div>

	        	<div class="panel-body">
		        		<table class="table" id="tickets">
		        			<thead>
		        				<tr>
		        					<th>Ticket ID</th>
		        					<th>Title</th>
		        					<th>Status</th>
		        					<th>Priority</th>
		        					<th style="text-align:center">Actions</th>
		        				</tr>
		        			</thead>
		        		
		        		</table>
	        	</div>
	        </div>
	    </div>
	</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#tickets').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('escalate.data') !!}',
        columns: [
            { data: 'ticket_id', name: 'ticket_id' },
            { data: 'title', name: 'title' },
            { data: 'status', name: 'status' },
            { data: 'priority', name: 'priority' },
            { data: 'action', name: 'action', sortable: 'false', searcheable: 'false'}
        ]
    });
});
</script>
@endpush

