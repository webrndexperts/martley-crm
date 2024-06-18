@extends('layouts.app')

@section('title', 'Patient List')

<!-- page content -->

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="x_panel">
            <div class="x_title">
                <h2>Add Patients to Clinitian</h2>

                <a href="{{ route('patient.assignment.get') }}" class="pull-right btn btn-info btn-sm" title="Assigned Patient">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <form action="{{ route('patient.assignment.save') }}" method="POST">
                    @csrf
                        
                    <div class="form-group">
                        <label for="clinician_id">Clinitian:</label>
                        <select name="clinician_id" id="clinician_id" class="form-control select2" required>
                            <option value="">-- Select Clinitian --</option>
                            @foreach($clinicians as $clinitian)
                                <option value="{{ $clinitian->id }}">{{ $clinitian->first_name }} {{ $clinitian->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="patient_id">Patient:</label>
                        <select name="patient_id[]" id="patient_id" class="form-control select2" multiple required>
                            <option value="">-- Select Patient --</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" style="display: block;" title="Submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function appendOptionsToSelect(select, children) {
            select.append($('<option>').text('-- Select Patient --').val(''));

            // Append each child as an option
            children.forEach(function(child) {
                var _name = `${child.first_name} ${child.last_name}`;
                select.append($('<option>').text(_name).val(child.id));
            });
        }
        
        function getPatients(value) {
            var select = $('#patient_id');
            select.empty();

            jQuery.ajax({
                url: "{{ route('patient.assignment.patient', ':clinic_id') }}".replace(':clinic_id', value),
                type: 'GET',
                success: function(response) {
                    appendOptionsToSelect(select, response);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data');
                    console.log(xhr.responseText);
                }
            });
        }

        jQuery(document).on('change', '#clinician_id', function() {
            getPatients(this.value);
        });
    </script>
@endpush