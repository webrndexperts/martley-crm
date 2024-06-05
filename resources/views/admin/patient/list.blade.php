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

                    <a href="{{ route('create-patient') }}" class="pull-right btn btn-info btn-sm" title="Add Patient">
                        <i class="fa fa-plus"></i> Add Patient
                    </a>

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

                            <tbody>
                                @foreach($patients as $patient)

                                    <tr>
                                        <td><strong>{{ ++$index }}</strong></td>

                                         <!-- <td><img src="{{ $patient->user->picture }}" class="img-circle" alt="user image" height="40" width="40"></td> -->
                                        
                                        <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                        <td>@if ($patient->user)  {{ $patient->user->email }}  @else  @endif</td> 
                                        <td>{{ $patient->phone }}</td>

                                        <td class="text-center">

                                            <a href="{{ route('edit-patient', $patient->id) }}"  class="btn btn-info btn-sm edit-btn1" title="Edit">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </a>
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