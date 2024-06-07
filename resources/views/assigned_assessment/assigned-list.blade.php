@extends('layouts.app')

@section('title', 'Assign Assessment List')

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
                    <h2>Assigned Assessment</h2>
                        @if(Auth::user()->user_type == 3)
                            <a href="{{ route('assign-assessment') }}" class="pull-right btn btn-info btn-sm" title="Assign Assessment">
                                <i class="fa fa-plus"></i> Assign Assessment
                            </a>
                        @endif

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
                                    <th>Pateint</th>                       
                                    <!-- <th>Due Date</th>                        -->
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody id="assessmentsTableBody">
                                @foreach($assessments as $index => $assessment)
                                    
                                    <tr>
                                        <td>{{ $index + 1 }}</td>

                                        <td>{{ $assessment->assessment->title }}</td>
                                    
                                        <td>{{ $assessment->patient->first_name }} {{ $assessment->patient->last_name }}</td>

                                        <td class="text-center">
                                            @if(Auth::user()->user_type == 3)
                                                <a class="btn btn-info btn-sm" href="{{ route('edit-assigned-assessment', $assessment->id) }}" title="Edit">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                            <!-- <a href="{{ route('show-assessment', $assessment->id) }}" title="View">
                                                <button type="button" class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye" aria-hidden="true"></i> 
                                                </button>
                                            </a>  -->

                                            <!-- <a href="{{route('destroy-assigned-assessment', $assessment->id)}}" class="delete" title="Delete">
                                                <button type="button" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </button>
                                            </a> -->
                                            
                                            <form action="{{ route('destroy-assigned-assessment', $assessment->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </button>
                                            </form>
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
