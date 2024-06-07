@extends('layouts.app')

@section('title', 'Patient List')

<!-- page content -->

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

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
                    <h2>Patient List</h2>
                    @if(Auth::user()->user_type == 2)
                        <a href="{{ route('create-patient') }}" class="pull-right btn btn-info btn-sm" title="Add Patient">
                            <i class="fa fa-plus"></i> Add Patient
                        </a>
                    @endif

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    @if(count($patients)<1) 
                        <div class="alert alert-dismissible fade in alert-info" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>

                            <strong>Sorry !</strong> No Data Found.
                        </div>

                      @else

                        <?php $index = 0; ?>

                        <table class="table table-striped table-bordered dataTable no-footer" id="datatable">
                            <thead>
                                <tr>
                                    <th>Sr. no.</th>
                                    <!-- <th>Picture</th> -->
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @if(Auth::user()->user_type == 2)
                                <tbody>
                                    @foreach($patients as $index => $patient)
                                        <tr>
                                            <td><strong>{{ $index + 1 }}</strong></td>
                                            <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                            <td>{{ $patient->user->email ?? '' }}</td>
                                            <td>{{ $patient->phone }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('edit-patient', $patient->id) }}" class="btn btn-info btn-sm" title="Edit">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @else
                                <tbody>
                                    @foreach($patients as $index => $patient)
                                        <tr>
                                            <td><strong>{{ $index + 1 }}</strong></td>
                                            <td>{{ $patient->patient->first_name }} {{ $patient->patient->last_name }}</td>
                                            <td>{{ $patient->patient->user->email ?? '' }}</td>
                                            <td>{{ $patient->patient->phone }}</td>
                                            <td class="text-center">
                                                --------
                                                <!-- <a href="{{ route('edit-patient', $patient->patient->id) }}" class="btn btn-info btn-sm" title="Edit">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </a> -->
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop