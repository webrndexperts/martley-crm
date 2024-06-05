@extends('layouts.app')

@section('title', 'Assessments')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(isset($errors))
                @if ( count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            @endif
            @if(\Session::has('msg'))

            @endif
            <div class="x_panel">

                <div class="x_title">
                    <h2>Assessments</h2>
                    <a href="{{ route('create-assessment') }}" class="pull-right btn btn-info btn-sm" title="Add Clinical Assessment">
                        <i class="fa fa-plus"></i> Add Assessment
                    </a>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    @if(count($assessments) == 0)
                        <div class="alert alert-dismissible fade in alert-info" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Sorry !</strong> No Data Found.
                        </div>
                    @else
                        <table class="table table-striped table-bordered dataTable no-footer" id="datatable">

                            <thead>
                                <tr>
                                    <th>Sr. no.</th>
                                    <th>Assessment Name</th>                   
                                    <th>Description</th>                       
                                    <th>Due Date</th>                       
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody id="assessmentsTableBody">
                                @foreach($assessments as $index => $assessment)
                                    
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $assessment->title }}</td>
                                    
                                        <td>{!! $assessment->description !!}</td>
                                        <td>{{ $assessment->due_date }}</td>   

                                        <td class="text-center">
                                            <a class="btn btn-info btn-sm" href="{{ route('edit-assessment', $assessment->id) }}" title="Edit">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </a>

                                            <a href="{{ route('show-assessment', $assessment->id) }}" title="View">
                                                <button type="button" class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye" aria-hidden="true"></i> 
                                                </button>
                                            </a> 

                                            <!-- <a href="{{route('destroy-assessment', $assessment)}}" class="delete" title="Delete">
                                                <button type="button" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </button>
                                            </a> -->
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
