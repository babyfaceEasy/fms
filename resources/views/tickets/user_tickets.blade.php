@extends('layouts.app')

@section('title', 'My Tickets')

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
	        <div class="panel panel-default">
	        	<div class="panel-heading">
	        		<i class="fa fa-ticket"> My Trouble Tickets</i>
	        	</div>

	        	<div class="panel-body">
		        		<table class="table" id="users-tickets">
		        			<thead>
		        				<tr>
		        					<th>Title</th>
		        					<th>Priority</th>
		        					<th>Status</th>
		        					<th>Category</th>
									<th>Action</th>
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
    $('#users-tickets').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('myTicket.data') !!}',
        columns: [
            { data: 'title', name: 'title' },
            { data: 'priority', name: 'priority' },
            { data: 'status', name: 'status' },
            { data: 'category_id', name: 'category_id'},
            { data: 'action', name: 'action', sortable: 'false', searcheable: 'false'}
        ]
    });
});
</script>
@endpush
