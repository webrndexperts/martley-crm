@extends('layouts.app')
@section('title', "Add New Form")

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
                    <h2>Create Form</h2>

                    <a href="{{ route('forms.index') }}" class="btn btn-primary" style="float:right;" title="Back">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                    </a>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <form method="POST" action="{{ route('forms.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Form Name</label>
                                <input type="text" class="form-field" placeholder="Form Name" name="name" required />
                            </div>

                            <div class="col-md-12 form-group">
                                <div class="form-group">
                                    <label for="description">Form Description:</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Enter description"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label>Form Button Text</label>
                                <input type="text" name="button" value="Submit" placeholder="Button Text" class="form-field" required />
                            </div>
                        
                            <div class="col-md-12 form-group form_fields">
                            <div class="add_fields">
                                <label>Form Fields</label>
                                <span class="add-new-field" role="button">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add Field
                                </span>
                            </div>
                            </div>
                        </div>

                        <div class="row append-rows" id="fieldsContainer">
                            @include('forms.includes.fields')
                        </div>

                        <div class="col-md-12 form-group mt-10">
                            <button class="button-form" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var index = 1;
        const fields = `{!! $renders !!}`

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
                    <input type="radio" disabled class="form-field redio_btns">
                    <input type="text" name="form[${_parent.dataset.index}][options][mcq][]" class="form-field" placeholder="Label" />
                    <span class="remove-mcq"><i class="fa fa-minus" aria-hidden="true"></i></span>
                </div>`;

                jQuery(_parent).append(div);
            }
        }

        jQuery(document).on('click', '.remove-field', function(e) {
            var _parent = e.target.closest('.main-fields-div');
            if(_parent) {
                _parent.remove();
            }
        })

        jQuery(document).on('click', '.add-new-field', function(e) {
            var _html = fields;

            _html = _html.replaceAll('form[0]', `form[${index}]`);
            _html = _html.replaceAll('data-index="0"', `data-index="${index}"`);

            index += 1;

            $('#fieldsContainer').append(_html);
        })

        jQuery(document).on('change', '.select-field-type', function(e) {
            var _parent = this.closest('.main-fields-div');

            if(typeof _parent != 'undefined') {
                var field = _parent.querySelector('.field-div');
                showFields(field, this.value);

                var _mcqField = _parent.querySelector('.mcq-parent');
                if(this.value == 'mcq') {
                    addMcqField(_mcqField);
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
            var _parent = e.target.closest('.mcq-field');
            if(_parent) {
                _parent.remove();
            }
        })
    </script>
@endpush