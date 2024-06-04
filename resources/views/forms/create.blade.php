@extends('layouts.app')

@section('content')

    <form method="POST" action="{{ route('forms.store') }}">
        @csrf

        <div class="row">
            <div class="col-md-10 form-group">
                <input type="text" class="form-field" placeholder="Name" required />
            </div>
            <div class="col-md-2">
                <span class="add-new-field" role="button">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add Field
                </span>
            </div>
        </div>

        <div class="row append-rows" id="fieldsContainer">
            @include('forms.includes.fields')
        </div>

        <div class="col-md-12 form-group">
            <input type="text" name="button" placeholder="Button Text" class="form-field" />
        </div>


        <div class="col-md-12 form-group">
            <button type="submit">Create</button>
        </div>
    </form>

@endsection

@push('scripts')
    <script type="text/javascript">
        jQuery(document).on('click', '.remove-field', function(e) {
            var _parent = e.target.closest('.main-fields-div');
            if(_parent) {
                _parent.remove();
            }
        })

        jQuery(document).on('click', '.add-new-field', function(e) {
            jQuery.ajax({
                url: "{{ route('fetch.fields') }}",
                type: "GET",
                success: function(response) {
                    $('#fieldsContainer').append(response.html);
                },
                error: function(xhr) {
                    console.error('Error fetching fields:', xhr.statusText);
                }
            });
        })
    </script>
@endpush