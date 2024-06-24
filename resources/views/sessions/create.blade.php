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
                                        <select name="clinician_id" class="form-control select2" required>
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
                                    <label>Session Title:</label>
                                    <input type="text" name="title" placeholder="Session Title" class="form-field @error('title') is-invalid @enderror" required value="{{ old('title') }}" />

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

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="comments">Comments:</label>
                                    <textarea id="comments" name="comments" class="form-control" rows="3" placeholder="Enter comments">{{ old('comments') }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="session_start_date">Start Date</label>
                                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" />

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
                                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" />

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
                                            <select name="start_hour" id="start_hour" class="form-control">
                                                @for ($hour = 0; $hour < 24; $hour++)
                                                    @php
                                                        $hourFormatted = sprintf('%02d', $hour);
                                                    @endphp
                                                    <option @if(old('start_hour') == $hourFormatted) selected @endif value="{{ $hourFormatted }}">{{ $hourFormatted }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="col-sm-6 end_date">
                                            <select name="start_minute" id="start_minute" class="form-control">
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
                                            <select name="end_hour" id="end_hour" class="form-control">
                                                @for ($hour = 0; $hour < 24; $hour++)
                                                    @php
                                                        $hourFormatted = sprintf('%02d', $hour);
                                                    @endphp
                                                    <option @if(old('end_hour') == $hourFormatted) selected @endif value="{{ $hourFormatted }}">{{ $hourFormatted }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="col-sm-6 end_form">
                                            <select name="end_minute" id="end_minute" class="form-control">
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

                            <div class="form-group">
                                <label for="file_upload">File Upload:</label>
                                <div id="file_inputs">
                                    <div class="file_input_container">
                                        <input type="file" name="upload_file" class="form-control-file" />
                                        <input type="text" name="link" value="{{ old('link') }}" class="form-control" placeholder="Link to file (optional)">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comments">Meeting Link:</label>
                                <input name="meeting_link" class="form-control" value="{{ old('meeting_link') }}" placeholder="Enter meeting link (optional)" />
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

        ClassicEditor.create( document.querySelector( '#comments' ) ).then(editor => {
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
    </script>
@endpush