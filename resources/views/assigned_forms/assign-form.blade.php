@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @if ($errors && $errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="x_panel">
                <div class="x_title">
                    <h2>Assign Form To Patient</h2>
                    <a href="{{ route('assign-form-list') }}" class="btn btn-primary" style="float:right;" title="Back">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                    </a>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <form action="{{route('assigned-form')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <?php
                            $_id = (array_key_exists('id', $_GET)) ? base64_decode($_GET['id']) : '';
                        ?>
                        
                        <div class="form-group">
                            <label for="patient_id">Patient:</label>
                            <select name="patient_id[]" id="patient_id" class="form-control select2" multiple required>
                                <option value="">-- Select Patient --</option>
                                @foreach($patients as $patient)
                                    <option @if($_id == $patient->id) selected @endif value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="form_id">Form:</label>
                            <select name="form_id" id="form_id" class="form-control select2" required>
                                <option value="">-- Select Form --</option>
                                @foreach($forms as $form)
                                    <option value="{{ $form->id }}">{{ $form->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" style="display: block;" title="Submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

@endpush
