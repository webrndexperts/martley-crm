@extends('layouts.app')
@section('title', "Update Form")

@section('content')

    <section class="form-section">
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

        <form method="POST" action="{{ route('forms.update', base64_encode($form->id)) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-10 form-group">
                    <input type="text" class="form-field" placeholder="Name" name="name" value="{{ $form->name }}" required />
                </div>
                <div class="col-md-2">
                    <span class="add-new-field" role="button">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add Field
                    </span>
                </div>
            </div>

            <div class="row append-rows" id="fieldsContainer">
                @include('forms.includes.update-fields')
            </div>

            <div class="col-md-12 form-group">
                <input type="text" name="button" value="{{ $form->submit }}" placeholder="Button Text" class="form-field" required />
            </div>
            <input type="hidden" name="removed" id="removed-input" />

            <div class="col-md-12 form-group">
                <button type="submit">Update</button>
            </div>
        </form>
    </section>

@endsection

@push('scripts')
    <script type="text/javascript">
        var count = "{{ count($form->fields) }}";
        var index = (count > 0) ? count : 1;

        function showFields(div, value) {
            for (var i = 0; i < div.children.length; i++) {
                var field = div.children[i];

                if(field.classList.contains(value)) {
                    field.classList.remove('hide');
                } else {
                    field.classList.add('hide');
                }
            }
        }

        function addMcqField(_parent) {
            if(_parent && typeof _parent != 'undefined') {
                var div = `<div class="col-md-3 mcq-field">
                    <input type="radio" disabled class="form-field">
                    <input type="text" name="form[${_parent.dataset.index}][options][mcq][]" class="form-field" placeholder="Label" />
                    <span class="remove-mcq"><i class="fa fa-minus" aria-hidden="true"></i></span>
                </div>`;

                jQuery(_parent).append(div);
            }
        }

        jQuery(document).on('click', '.remove-field', function(e) {
            var _parent = this.closest('.main-fields-div');
            if(_parent) {
                _parent.remove();
            }

            if(this.dataset && this.dataset.removed) {
                var inp = document.getElementById('removed-input');
                inp.value = (inp.value) ? `${inp.value},${this.dataset.removed}` : this.dataset.removed;
            }


        })

        jQuery(document).on('click', '.add-new-field', function(e) {
            jQuery.ajax({
                url: "{{ route('fetch.fields') }}",
                type: "GET",
                success: function(response) {
                    var _html = response.html;

                    _html = _html.replaceAll('form[0]', `form[${index}]`);
                    _html = _html.replaceAll('data-index="0"', `data-index="${index}"`);

                    index += 1;

                    $('#fieldsContainer').append(_html);
                },
                error: function(xhr) {
                    console.error('Error fetching fields:', xhr.statusText);
                }
            });
        })

        jQuery(document).on('change', '.select-field-type', function(e) {
            var _parent = this.closest('.main-fields-div');

            if(typeof _parent != 'undefined') {
                var field = _parent.querySelector('.field-div');
                showFields(field, this.value);

                var _mcqField = _parent.querySelector('.mcq-parent');
                if(this.value == 'mcq') {
                    addMcqField(_mcqField);
                } else {
                    if(_mcqField.children.length > 1) {
                        for (let i = _mcqField.children.length - 1; i > 0; i--) {
                            // Remove the child element
                            _mcqField.removeChild(_mcqField.children[i]);
                        }
                    }
                }
            }
        })

        jQuery(document).on('click', '.add-mcq', function(e) {
            var _parent = this.closest('.mcq-parent');

            if(_parent) {
                addMcqField(_parent);
            }
        })

        jQuery(document).on('click', '.remove-mcq', function(e) {
            var _parent = this.closest('.mcq-field');
            if(_parent) {
                _parent.remove();
            }
        })
    </script>
@endpush