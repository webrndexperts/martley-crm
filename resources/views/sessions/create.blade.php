@extends('layouts.app')
@section('title', "Add New Session")

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 add_field">
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

            <div class="x_panel">
                <div class="x_title">
                    <h2>Create Session and meeting</h2>

                    <a href="{{ route('sessions.index') }}" class="btn btn-info" style="float:right;" title="Back">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                    </a>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <form method="POST" action="{{ route('sessions.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            @if(Auth::user()->user_type == '2')
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Clinician:</label>
                                        <select name="clinician_id" id="clinician_id" class="form-control @error('clinician_id') is-invalid @enderror select2 field-change" required>
                                            <option value="">-- Select Clinitian --</option>
                                            @foreach($clinicians as $clinitian)
                                                <option @if(old('clinician_id') == $clinitian->id) selected @endif value="{{ $clinitian->id }}">{{ $clinitian->first_name }} {{ $clinitian->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="d-flex-s">
                                        Patient:
                                        <div class="field-loader hide">
                                            <img src="{{ url('public/new/img/double_ring.svg') }}">
                                        </div>
                                    </label>
                                    <select name="patient_id" id="patient_id" class="form-control @error('patient_id') is-invalid @enderror select2 field-change" required>
                                        <option value="">-- Select Patient --</option>
                                        @foreach($patients as $patient)
                                            <option @if(old('patient_id') == $patient->id) selected @endif value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Session Title:</label>
                                    <div class="d-flex-s">
                                        <div id="title-name" class="session-title-field @error('title') is-invalid @enderror">
                                            <input type="hidden" name="title_first" value="{{ old('title_first') }}" />
                                            <span>{{ old('title_first') }}</span>
                                        </div>
                                        <div class="session-text-field">
                                            <input type="text" name="title" id="title" placeholder="Session Title" class="form-field @error('title') is-invalid @enderror" value="{{ old('title') }}" />
                                        </div>
                                    </div>

                                    @error('title')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter description">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="session_start_date">Start Date</label>
                                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror field-change" value="{{ old('start_date') }}" />

                                    @error('start_date')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 end_form">
                                <div class="form-group">
                                    <label for="session_end_date">End Date</label>
                                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror field-change" value="{{ old('end_date') }}" />

                                    @error('end_date')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="session_start_time">Session Start Time:</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <select name="start_hour" id="start_hour" class="form-control field-change">
                                                @for ($hour = 0; $hour < 24; $hour++)
                                                    @php
                                                        $hourFormatted = sprintf('%02d', $hour);
                                                    @endphp
                                                    <option @if(old('start_hour') == $hourFormatted) selected @endif value="{{ $hourFormatted }}">{{ $hourFormatted }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="col-sm-6 end_date">
                                            <select name="start_minute" id="start_minute" class="form-control field-change">
                                                @for ($minute = 0; $minute < 60; $minute += 15)
                                                    @php
                                                        $minuteFormatted = sprintf('%02d', $minute);
                                                    @endphp
                                                    <option @if(old('start_minute') == $minuteFormatted) selected @endif value="{{ $minuteFormatted }}">{{ $minuteFormatted }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="session_start_time">Session End Time:</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <select name="end_hour" id="end_hour" class="form-control field-change">
                                                @for ($hour = 0; $hour < 24; $hour++)
                                                    @php
                                                        $hourFormatted = sprintf('%02d', $hour);
                                                    @endphp
                                                    <option @if(old('end_hour') == $hourFormatted) selected @endif value="{{ $hourFormatted }}">{{ $hourFormatted }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="col-sm-6 end_form">
                                            <select name="end_minute" id="end_minute" class="form-control field-change">
                                                @for ($minute = 0; $minute < 60; $minute += 15)
                                                    @php
                                                        $minuteFormatted = sprintf('%02d', $minute);
                                                    @endphp
                                                    <option @if(old('end_minute') == $minuteFormatted) selected @endif value="{{ $minuteFormatted }}">{{ $minuteFormatted }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="file_upload">File Upload:</label>
                                    
                                    <div class="file_input_container">
                                        <input type="file" name="upload_file" class="form-control-file" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 form-group mt-10">
                            <button class="button-form btn btn-info" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">

        let _clinical = "{{ $clinicName }}";

        ClassicEditor.create( document.querySelector( '#description' ) ).then(editor => {
            // Listen for the 'focus' event to adjust the height on focus
            editor.ui.focusTracker.on('change:isFocused', (evt, propertyName, newValue, oldValue) => {
                if (newValue) {
                    // Set the height of the editable area when editor gains focus
                    editor.ui.getEditableElement().style.height = '100px'; // Adjust the height as needed
                }
            });
        }).catch( error => {
            console.error( error );
        });

        document.addEventListener('DOMContentLoaded', function() {
            const startTimeInputHour = document.getElementById('start_hour');
            const startTimeInputMinute = document.getElementById('start_minute');
            const endTimeInputHour = document.getElementById('end_hour');
            const endTimeInputMinute = document.getElementById('end_minute');

            // Add event listeners to start time inputs
            startTimeInputHour.addEventListener('change', updateEndTime);
            startTimeInputMinute.addEventListener('change', updateEndTime);

            function updateEndTime() {
                const startHour = parseInt(startTimeInputHour.value);
                const startMinute = parseInt(startTimeInputMinute.value);

                if (!isNaN(startHour) && !isNaN(startMinute)) {
                    // Calculate end time as 1 hour (60 minutes) after start time
                    const endTotalMinutes = startHour * 60 + startMinute + 60;
                    let endHour = Math.floor(endTotalMinutes / 60);
                    const endMinute = endTotalMinutes % 60;
                    endHour = (endHour > 23) ? '00' : endHour;

                    // Update end time select inputs
                    endTimeInputHour.value = endHour.toString().padStart(2, '0');
                    endTimeInputMinute.value = endMinute.toString().padStart(2, '0');

                    // endTimeInputMinute.dispatchEvent(new Event('change'));
                    $(endTimeInputMinute).trigger('change');
                }
            }
        });

        function getSelectText(field) {
            var text = '';
            if(field.type == 'select-one' && field.value) {
                var selectedOption = field.options[field.selectedIndex],
                text = selectedOption.text;
            }

            return text;
        }

        function generateTitle(value) {
            var div = document.getElementById('title-name'),
            fields = document.getElementsByClassName('field-change'), _title = '';

            var _clinic = (_clinical) ? _clinical : '', _patient = '', _start = '', _end = '', _startHr = '', _startMn = '',
            _endHr = '', _endMn = '';

            for (var i = 0; i < fields.length; i++) {
                var _field = fields[i];

                if(_field.name == 'clinician_id') { _clinic = getSelectText(_field); }
                if(_field.name == 'patient_id') { _patient = getSelectText(_field); }
                if(_field.name == 'start_date') { _start = _field.value; }
                if(_field.name == 'end_date') { _end = _field.value; }
                if(_field.name == 'start_hour') { _startHr = _field.value; }
                if(_field.name == 'start_minute') { _startMn = _field.value; }
                if(_field.name == 'end_hour') { _endHr = _field.value; }
                if(_field.name == 'end_minute') { _endMn = _field.value; }
            }

            _title = (_clinic) ? _clinic : '';
            _title += (_patient) ? ` ${_patient}` : '';

            _title += (_start) ? ` ${_start}` : '';
            if(_start) {
                _title += (_startHr && _startMn) ? ` ${_startHr}:${_startMn}` : '';
            }

            _title += (_end) ? ` ${_end}` : '';
            if(_end) {
                _title += (_endHr && _endMn) ? ` ${_endHr}:${_endMn}` : '';
            }

            var _span = div.querySelector('span'), _inp = div.querySelector('input');
            if(_span) {
                _span.innerText = _title;
            }
            if(_inp) {
                _inp.value = _title;
            }
        }

        jQuery(document).on('change', '.field-change', function() {
            generateTitle()
        });
    </script>

    @if(Auth::user()->user_type == '2')
        <script type="text/javascript">
            let oldPatient = "{{ old('patient_id') }}", oldClinic = "{{ old('clinician_id') }}";

            if(oldClinic) {
                getPatients(oldClinic);
            }

            function appendOptionsToSelect(select, children) {
                select.append($('<option>').text('-- Select Patient --').val(''));

                // Append each child as an option
                children.forEach(function(child) {
                    var _name = `${child.first_name} ${child.last_name}`;

                    var _option = $('<option>').text(_name).val(child.id);
                    if(oldPatient == child.id) {
                        _option.prop('selected', true);
                    }

                    select.append(_option);
                });
            }

            function showLoader(check) {
                var loader = document.querySelector('.field-loader');

                if(loader && typeof loader != 'undefined') {
                    if(check) {
                        loader.classList.remove('hide')
                    } else {
                        loader.classList.add('hide')
                    }
                }
            }
            
            function getPatients(value) {
                var select = $('#patient_id');
                select.empty();

                jQuery.ajax({
                    url: "{{ route('patient.assignment.clinic', ':clinic_id') }}".replace(':clinic_id', value),
                    type: 'GET',
                    success: function(response) {
                        showLoader(false);
                        appendOptionsToSelect(select, response);
                    },
                    beforeSend: function() {
                        showLoader(true);
                    },
                    error: function(xhr, status, error) {
                        showLoader(false);
                        console.error('Error fetching data');
                        console.log(xhr.responseText);
                    }
                });
            }

            jQuery(document).on('change', '#clinician_id', function() {
                getPatients(this.value);
            });
        </script>
    @endif
@endpush