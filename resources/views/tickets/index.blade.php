@extends('layouts.app')

@section('title', 'All Tickets')

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			@include('includes.flash')
	        <div class="panel panel-default">
	        	<div class="panel-heading">
	        		<i class="fa fa-ticket">Trouble Tickets</i>
	        	</div>

	        	<div class="panel-body">
		        		<table class="table" id="tickets">
		        			<thead>
		        				<tr>
		        					<th>Category</th>
		        					<th>Title</th>
		        					<th>Status</th>
		        					<th>Last Updated</th>
		        					<th style="text-align:center" colspan="2">Actions</th>
		        				</tr>
		        			</thead>
		        		
		        		</table>
		        	@endif
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
        ajax: '{!! route('tickets.data') !!}',
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

