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
	        		<div class="table-responsive">
		        		<table class="table" id="tickets">
		        			<thead>
		        				<tr>
		        					<th>#</th>
		        					<th>Category</th>
		        					<th>Title</th>
		        					<th>Status</th>
		        					<th>Last Updated</th>
		        					<th style="text-align:center">Actions</th>
		        				</tr>
		        			</thead>
		        		</table>
		        	</div>
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
        	{ data: 'rownum', name: 'rownum' },
            { data: 'title', name: 'title' },
            { data: 'priority', name: 'priority' },
            { data: 'status', name: 'status' },
            { data: 'category_id', name: 'category_id'},
            { data: 'action', name: 'action', sortable: 'false', searcheable: 'false'}
        ],
        "aoColumnDefs": [
      		{ "bSearchable": false, "aTargets": [0, 5 ] }
    	],

    	"aoColumnDefs": [
      		{ "bSortable": false, "aTargets": [0, 5 ] }
    	] 

    });
});
</script>
@endpush

