<!-- resources/views/assessments/assessment_details.blade.php -->
@extends('layouts.app')

@section('title', 'View Assessment')

<!-- page content -->
@section('content')

    <div class="row">
        <div>
            <div class="x_title">
                    <h2>View Assessment</h2>
                    <a href="{{route('assessment-list')}}" class="btn btn-primary" style="float:right;" title="Back">Back</a>
                    <div class="clearfix"></div>
            </div>
        </div>

        <div class="container">

            <!-- Assessment Details Tabs -->
            <ul class="nav nav-tabs" id="assessmentDetailsTabs" role="tablist">
                <!-- Tab 1: Details -->
                <li class="nav-item active">
                    <a class="nav-link " id="details-tab" data-toggle="tab" href="#details" role="tab"
                        aria-controls="details" aria-selected="true">Details</a>
                </li>
                
                <!-- Tab 2: Submissions -->
                <li class="nav-item">
                    <a class="nav-link" id="submissions-tab" data-toggle="tab" href="#submissions" role="tab"
                        aria-controls="submissions" aria-selected="false">Submissions</a>
                </li>
            </ul>

            <!-- Assessment Details Content -->
            <div class="tab-content mt-3">
                <!-- Tab 1: Details -->

                <div class="tab-pane fade  active in students-table module" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <table>
                        <tbody>
                            <tr>
                                <th>Assessment title</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Date created</th>
                            </tr>
                            <tr>
                                <td>{{ $data->title }}</td>
                                <td>{!! $data->description !!}</td>
                                <td>{{ $data->due_date }}</td>
                                <td>{{ $data->created_at }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2 style="margin-top:20px;"><b>Questions</b></h2>
                        <table>
                            <tr>
                                <th>Question</td>
                                <th>Answer</td>
                            
                            </tr>
                            @foreach($questions as $index => $que)
                            <tr>
                                <td>Question {{ $index + 1 }}: {{ $que->question }}</td>

                                <?php
                                    $answers = explode(',', $que['answer']);
                                ?>
                                <td>
                                    @foreach($answers as $answer)
                                {{$answer}},
                                    @endforeach  
                                </td>
                                
                            </tr>
                            @endforeach
                        </table>
                </div>

                <!-- Tab 2: Submissions -->
               
                <div class="tab-pane fade" id="submissions" role="tabpanel" aria-labelledby="submissions-tab">
                    <h2>Submissions</h2>
                    <!-- Submissions Table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Submission date</th>
                                <th>Student name</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
@endsection