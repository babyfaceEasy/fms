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
                            <a href="{{route('test.sms')}}">
                            	Let's Go
                            </a>
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                            <label for="state" class="col-md-4 control-label">Region / Department</label>

                            <div class="col-md-6">
                                <select multiple="true" id="state" type="state" class="form-control" name="state[]">
                                	@foreach ($states as $state)
										<option value="{{ $state->state_id }}">{{ $state->name }}</option>
                                	@endforeach
                                </select>

                                @if ($errors->has('state'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
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
														<div class="form-group{{ $errors->has('time_of_occurence1') ? ' has-error' : '' }}">
		                            <label for="time_of_occurence1" class="col-md-4 control-label">Time of occurence</label>

		                            <div class="col-md-6">
		                                <input id="time_of_occurence1" type="datetime" class="form-control" name="time_of_occurence1" value="{{ old('time_of_occurence1') }}">

		                                @if ($errors->has('time_of_occurence1'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('time_of_occurence1') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('cause_of_failure1') ? ' has-error' : '' }}">
		                            <label for="cause_of_failure1" class="col-md-4 control-label">Cause of failure</label>

		                            <div class="col-md-6">
		                                <input id="cause_of_failure1" type="text" class="form-control" name="case_of_failure1" value="{{ old('cause_of_failure1') }}">

		                                @if ($errors->has('cause_of_failure1'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('cause_of_failure1') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>

														<div id="impact1"  class="form-group{{ $errors->has('impact1') ? ' has-error' : '' }} ">
		                            <label for="impact1" class="col-md-4 control-label">Impact</label>

		                            <div class="col-md-6">
		                                <textarea rows="10" id="impact1" class="form-control" name="impact1"></textarea>

		                                @if ($errors->has('impact1'))

		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('impact1') }}</strong>
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
		                                <input id="site_id" type="text" class="form-control" name="site_id" value="{{ old('site_id') }}">

		                                @if ($errors->has('site_id'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('site_id') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<!--<div class="form-group{{ $errors->has('region') ? ' has-error' : '' }}">
		                            <label for="node_a" class="col-md-4 control-label">Region</label>

		                            <div class="col-md-6">
		                                <input id="node_a" type="text" class="form-control" name="region" value="{{ old('node_a') }}">

		                                @if ($errors->has('node_a'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('node_a') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>-->
														<div class="form-group{{ $errors->has('bsc') ? ' has-error' : '' }}">
		                            <label for="bsc" class="col-md-4 control-label">BSC/RNC</label>

		                            <div class="col-md-6">
		                                <input id="bsc" type="text" class="form-control" name="bsc" value="{{ old('bsc') }}">

		                                @if ($errors->has('bsc'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('bsc') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('time_of_occurence2') ? ' has-error' : '' }}">
		                            <label for="time_of_occurence2" class="col-md-4 control-label">Time of occurence</label>

		                            <div class="col-md-6">
		                                <input id="time_of_occurence2" type="datetime" class="form-control" name="time_of_occurence2" value="{{ old('time_of_occurence2') }}">

		                                @if ($errors->has('time_of_occurence2'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('time_of_occurence2') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('cause_of_failure2') ? ' has-error' : '' }}">
		                            <label for="cause_of_failure2" class="col-md-4 control-label">Cause of failure</label>

		                            <div class="col-md-6">
		                                <input id="cause_of_failure2" type="text" class="form-control" name="cause_of_failure2" value="{{ old('cause_of_failure2') }}">

		                                @if ($errors->has('cause_of_failure2'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('cause_of_failure2') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div id="impact2"  class="form-group{{ $errors->has('impact2') ? ' has-error' : '' }}">
		                            <label for="impact2" class="col-md-4 control-label">Impact</label>

		                            <div class="col-md-6">
		                                <textarea rows="10" id="impact2" class="form-control" name="impact2"></textarea>

		                                @if ($errors->has('impact2'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('impact2') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>

		                        <div class="col-md-6 col-md-offset-4">
		                                <button type="submit" class="btn btn-primary btn-block">
		                                    <i class="fa fa-btn fa-ticket"></i> Open Base Station Switch Trouble Ticket
		                                </button>
		                            </div>
												</div>
												<div id="ipnetwork" class="hidden_info">
													<div class="form-group">
														<span class="col-md-offset-4 text text-muted" style="padding-left:20px;">Ip Network</span>
													</div>
														<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
		                            <label for="location" class="col-md-4 control-label">Location</label>

		                            <div class="col-md-6">
		                                <input id="location" type="text" class="form-control" name="location" value="{{ old('location') }}">

		                                @if ($errors->has('location'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('location') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('time_of_occurence3') ? ' has-error' : '' }}">
		                            <label for="node_a" class="col-md-4 control-label">Time of occurence</label>

		                            <div class="col-md-6">
		                                <input id="time_of_occurence3" type="datetime" class="form-control" name="time_of_occurence3" value="{{ old('time_of_occurence3') }}">

		                                @if ($errors->has('time_of_occurence3'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('time_of_occurence3') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
														<div class="form-group{{ $errors->has('cause_of_failure3') ? ' has-error' : '' }}">
		                            <label for="cause_of_failure3" class="col-md-4 control-label">Cause of failure</label>

		                            <div class="col-md-6">
		                                <input id="cause_of_failure3" type="text" class="form-control" name="cause_of_failure3" value="{{ old('cause_of_failure3') }}">

		                                @if ($errors->has('cause_of_failure3'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('cause_of_failure3') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>

														<div id="impact3"  class="form-group{{ $errors->has('message') ? ' has-error' : '' }} ">
		                            <label for="impact3" class="col-md-4 control-label">Impact</label>

		                            <div class="col-md-6">
		                                <textarea rows="10" id="impact3" class="form-control" name="impact3"></textarea>

		                                @if ($errors->has('impact3'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('impact3') }}</strong>
		                                    </span>
		                                @endif
		                            </div>
		                        </div>
		                        <div class="col-md-6 col-md-offset-4">
		                                <button type="submit" class="btn btn-primary btn-block">
		                                    <i class="fa fa-btn fa-ticket"></i> Open IP Network Trouble Ticket
		                                </button>
		                            </div>
												</div>



                    </form>
	            </div>
	        </div>
	    </div>
	</div>
@endsection
