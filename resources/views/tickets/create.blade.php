@extends('layouts.app')

@section('title', 'Open Ticket')

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
	        <div class="panel panel-default">
	            <div class="panel-heading">Open New Ticket</div>

	            <div class="panel-body">
                    @include('includes.flash')

	                <form class="form-horizontal" role="form" method="POST" action="{{ url('/new_ticket') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="category" class="col-md-4 control-label">Category</label>

                            <div class="col-md-6">
                                <select id="category" type="category" class="form-control" name="category">
                                	<option value="">Select Category</option>
                                	@foreach ($categories as $category)
										<option value="{{ $category->id }}">{{ $category->name }}</option>
                                	@endforeach
                                </select>

                                @if ($errors->has('category'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                            <label for="priority" class="col-md-4 control-label">Priority</label>

                            <div class="col-md-6">
                                <select id="priority" type="" class="form-control" name="priority">
                                	<option value="">Select Priority</option>
                                	<option value="low">Low</option>
                                	<option value="medium">Medium</option>
                                	<option value="high">High</option>
                                </select>

                                @if ($errors->has('priority'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
												<div id="transmission" class=" {{ $errors->has('node_a')
													 														|| $errors->has('node_b')
																											|| $errors->has('vendor')
																											|| $errors->has('cause_of_failure')
																											|| $errors->has('impact')
																											|| $errors->has('time_of_occurence') ? '' : 'hidden_info' }}">
													<div class="form-group">
														<span class="col-md-offset-4 text text-muted" style="padding-left:20px;">Transmission</span>
													</div>
														<div class="form-group{{ $errors->has('node_a') ? ' has-error' : '' }}">
		                            <label for="node_a" class="col-md-4 control-label">Node A</label>

		                            <div class="col-md-6">
		                                <input id="node_a" type="text" class="form-control" name="node_a" value="{{ old('node_a') }}">

		                                @if ($errors->has('node_a'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('node_a') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('node_b') ? ' has-error' : '' }}">
		                            <label for="node_b" class="col-md-4 control-label">Node B</label>

		                            <div class="col-md-6">
		                                <input id="node_b" type="text" class="form-control" name="node_b" value="{{ old('node_b') }}">

		                                @if ($errors->has('node_b'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('node_b') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('vendor') ? ' has-error' : '' }}">
		                            <label for="vendor" class="col-md-4 control-label">Vendor</label>

		                            <div class="col-md-6">
		                                <input id="vendor" type="text" class="form-control" name="vendor" value="{{ old('vendor') }}">

		                                @if ($errors->has('vendor'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('vendor') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('time_of_occurence') ? ' has-error' : '' }}">
		                            <label for="time_of_occurence" class="col-md-4 control-label">Time of occurence</label>

		                            <div class="col-md-6">
		                                <input id="time_of_occurence" type="datetime" class="form-control" name="time_of_occurence" value="{{ old('node_a') }}">

		                                @if ($errors->has('time_of_occurence'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('time_of_occurence') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('cause_of_failure') ? ' has-error' : '' }}">
		                            <label for="cause_of_failure" class="col-md-4 control-label">Cause of failure</label>

		                            <div class="col-md-6">
		                                <input id="cause_of_failure" type="text" class="form-control" name="cause_of_failure" value="{{ old('cause_of_failure') }}">

		                                @if ($errors->has('cause_of_failure'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('cause_of_failure') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>

														<div id="impact"  class="form-group{{ $errors->has('impact') ? ' has-error' : '' }} ">
		                            <label for="impact" class="col-md-4 control-label">Impact</label>

		                            <div class="col-md-6">
		                                <textarea rows="10" id="impact" class="form-control" name="impact"></textarea>

		                                @if ($errors->has('impact'))

		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('impact') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div id="ticketBtn" class="form-group ">
		                            <div class="col-md-6 col-md-offset-4">
		                                <button type="submit" class="btn btn-primary btn-block">
		                                    <i class="fa fa-btn fa-ticket"></i> Open Transmission Trouble Ticket
		                                </button>
		                            </div>
		                        </div>
														{{-- end of transmission form --}}
												</div>
												<div id="base_switch" class="hidden_info">
														<div class="form-group">
															<span class="col-md-offset-4 text text-muted" style="padding-left:20px;"> Base station switch</span>
														</div>
														<div class="form-group{{ $errors->has('site_id') ? ' has-error' : '' }}">
		                            <label for="site_id" class="col-md-4 control-label">Site ID</label>

		                            <div class="col-md-6">
		                                <input id="node_a" type="text" class="form-control" name="site_id" value="{{ old('site_id') }}">

		                                @if ($errors->has('site_id'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('site_id') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('region') ? ' has-error' : '' }}">
		                            <label for="node_a" class="col-md-4 control-label">Region</label>

		                            <div class="col-md-6">
		                                <input id="node_a" type="text" class="form-control" name="region" value="{{ old('node_a') }}">

		                                @if ($errors->has('node_a'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('node_a') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('node_a') ? ' has-error' : '' }}">
		                            <label for="node_a" class="col-md-4 control-label">BSC/RNC</label>

		                            <div class="col-md-6">
		                                <input id="node_a" type="text" class="form-control" name="bsc" value="{{ old('node_a') }}">

		                                @if ($errors->has('node_a'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('node_a') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('node_a') ? ' has-error' : '' }}">
		                            <label for="node_a" class="col-md-4 control-label">Time of occurence</label>

		                            <div class="col-md-6">
		                                <input id="node_a" type="datetime" class="form-control" name="time_of_occurence" value="{{ old('node_a') }}">

		                                @if ($errors->has('node_a'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('node_a') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('node_a') ? ' has-error' : '' }}">
		                            <label for="node_a" class="col-md-4 control-label">Cause of failure</label>

		                            <div class="col-md-6">
		                                <input id="node_a" type="text" class="form-control" name="cause_of_failure" value="{{ old('node_a') }}">

		                                @if ($errors->has('node_a'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('node_a') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div id="message"  class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
		                            <label for="message" class="col-md-4 control-label">Impact</label>

		                            <div class="col-md-6">
		                                <textarea rows="10" id="message" class="form-control" name="message"></textarea>

		                                @if ($errors->has('message'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('message') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
												</div>
												<div id="ipnetwork" class="hidden_info">
													<div class="form-group">
														<span class="col-md-offset-4 text text-muted" style="padding-left:20px;">Ip Network</span>
													</div>
														<div class="form-group{{ $errors->has('node_a') ? ' has-error' : '' }}">
		                            <label for="node_a" class="col-md-4 control-label">Location</label>

		                            <div class="col-md-6">
		                                <input id="node_a" type="text" class="form-control" name="location" value="{{ old('node_a') }}">

		                                @if ($errors->has('node_a'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('node_a') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('node_a') ? ' has-error' : '' }}">
		                            <label for="node_a" class="col-md-4 control-label">Time of occurence</label>

		                            <div class="col-md-6">
		                                <input id="node_a" type="datetime" class="form-control" name="time_of_occurence" value="{{ old('node_a') }}">

		                                @if ($errors->has('node_a'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('node_a') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('node_a') ? ' has-error' : '' }}">
		                            <label for="node_a" class="col-md-4 control-label">Cause of failure</label>

		                            <div class="col-md-6">
		                                <input id="node_a" type="text" class="form-control" name="cause_of_failure" value="{{ old('node_a') }}">

		                                @if ($errors->has('node_a'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('node_a') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>

														<div id="message"  class="form-group{{ $errors->has('message') ? ' has-error' : '' }} ">
		                            <label for="message" class="col-md-4 control-label">Impact</label>

		                            <div class="col-md-6">
		                                <textarea rows="10" id="message" class="form-control" name="message"></textarea>

		                                @if ($errors->has('message'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('message') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
												</div>



                    </form>
	            </div>
	        </div>
	    </div>
	</div>
@endsection
