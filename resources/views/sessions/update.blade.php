@extends('layouts.app')
@section('title', "Update Session")

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
                    <h2>Update Session and meeting</h2>

                    <a href="{{ route('sessions.index') }}" class="btn btn-info" style="float:right;" title="Back">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                    </a>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <form method="POST" action="{{ route('sessions.update', base64_encode($session->id)) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            @if(Auth::user()->user_type == '2')
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Clinician:</label>
                                        <select name="clinician_id" class="form-control select2" required>
                                            <option value="">-- Select Clinitian --</option>
                                            @foreach($clinicians as $clinitian)
                                                <option @if($session->clinician_id == $clinitian->id) selected @endif value="{{ $clinitian->id }}">{{ $clinitian->first_name }} {{ $clinitian->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Session Title:</label>
                                    <input type="text" name="title" placeholder="Session Title" class="form-field @error('title') is-invalid @enderror" required value="{{ $session->title }}" />

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
                                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter description">{{ $session->description }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="session_start_date">Start Date</label>
                                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ date('Y-m-d', strtotime($session->start_date)) }}" />

                                    @error('start_date')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="session_end_date">End Date</label>
                                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ date('Y-m-d', strtotime($session->end_date)) }}" />

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
                                    <?php
                                        $_start = ''; $_end = '';
                                        $_time = date('H:i', strtotime($session->start_date));
                                        $_time = explode(':', $_time);

                                        if(count($_time)) {
                                            $_start = $_time[0]; $_end = $_time[1];
                                        }
                                    ?>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <select name="start_hour" id="start_hour" class="form-control">
                                                @for ($hour = 0; $hour < 24; $hour++)
                                                    @php
                                                        $hourFormatted = sprintf('%02d', $hour);
                                                    @endphp
                                                    <option @if($_start == $hourFormatted) selected @endif value="{{ $hourFormatted }}">{{ $hourFormatted }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="col-sm-6">
                                            <select name="start_minute" id="start_minute" class="form-control">
                                                @for ($minute = 0; $minute < 60; $minute += 15)
                                                    @php
                                                        $minuteFormatted = sprintf('%02d', $minute);
                                                    @endphp
                                                    <option @if($_end == $minuteFormatted) selected @endif value="{{ $minuteFormatted }}">{{ $minuteFormatted }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="session_start_time">Session End Time:</label>

                                    <?php
                                        $_lstart = ''; $_lend = '';
                                        $_ltime = date('H:i', strtotime($session->end_date));
                                        $_ltime = explode(':', $_ltime);

                                        if(count($_ltime)) {
                                            $_lstart = $_ltime[0]; $_lend = $_ltime[1];
                                        }
                                    ?>


                                    <div class="row">
                                        <div class="col-sm-6">
                                            <select name="end_hour" id="end_hour" class="form-control">
                                                @for ($hour = 0; $hour < 24; $hour++)
                                                    @php
                                                        $hourFormatted = sprintf('%02d', $hour);
                                                    @endphp
                                                    <option @if($_lstart == $hourFormatted) selected @endif value="{{ $hourFormatted }}">{{ $hourFormatted }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="col-sm-6">
                                            <select name="end_minute" id="end_minute" class="form-control">
                                                @for ($minute = 0; $minute < 60; $minute += 15)
                                                    @php
                                                        $minuteFormatted = sprintf('%02d', $minute);
                                                    @endphp
                                                    <option @if($_lend == $minuteFormatted) selected @endif value="{{ $minuteFormatted }}">{{ $minuteFormatted }}</option>
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
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 form-group mt-10">
                            <button class="button-form btn btn-info" type="submit">Update</button>
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