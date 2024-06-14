@if($form && count($form->fields))
    @foreach($form->fields as $k => $field)
        <div class="col-md-12 main-fields-div">
            <div class="d-flex-cust">
                <div class="form-group w-50-cust">
                    <select name="form[{{ $k }}][type]" class="form-field select-field-type">
                        <option value="">-- Select Field Type --</option>
                        <option @if($field->type == 'input') selected @endif value="input">Input</option>
                        <option @if($field->type == 'password') selected @endif value="password">Password</option>
                        <option @if($field->type == 'textarea') selected @endif value="textarea">Textarea</option>
                        <option @if($field->type == 'file') selected @endif value="file">File</option>
                        <option @if($field->type == 'number') selected @endif value="number">Number</option>
                        <option @if($field->type == 'tel') selected @endif value="tel">Telephone</option>
                        <option @if($field->type == 'email') selected @endif value="email">Email</option>
                        <option @if($field->type == 'checkbox') selected @endif value="checkbox">Checkbox</option>
                        <option @if($field->type == 'mcq') selected @endif value="mcq">Multiple Choice Questions</option>
                    </select>
                </div>
                
                <div class="form-group w-50-cust">
                    <input type="text" name="form[{{ $k }}][label]" placeholder="Label" class="form-field" value="{{ $field->label }}" />
                    <input type="hidden" name="form[{{ $k }}][id]" value="{{ $field->id }}" />
                </div>
            </div>

            <?php $options = json_decode($field->options); ?>

            <div class="form-group field-div">
                <!-- <textarea disabled class="form-control textarea {{ ($field->type == 'textarea') ? '' : 'hide' }}" placeholder="Textarea" rows="3"></textarea>
                <input type="file" disabled class="form-field file {{ ($field->type == 'file') ? '' : 'hide' }}" />
                <input type="text" disabled class="form-field input {{ ($field->type == 'input') ? '' : 'hide' }}" placeholder="Input" />
                <input type="text" disabled class="form-field password {{ ($field->type == 'password') ? '' : 'hide' }}" placeholder="Password" />
                <input type="number" disabled class="form-field number {{ ($field->type == 'number') ? '' : 'hide' }}" placeholder="Number" />
                <input type="tel" disabled class="form-field tel {{ ($field->type == 'tel') ? '' : 'hide' }}" placeholder="Telephone" />
                <input type="email" disabled class="form-field email {{ ($field->type == 'email') ? '' : 'hide' }}" placeholder="Email" />
                <input type="checkbox" disabled class="form-control checkbox {{ ($field->type == 'checkbox') ? '' : 'hide' }}" placeholder="Checkbox" /> -->

                <div class="mcq {{ ($field->type == 'mcq') ? '' : 'hide' }} mcq-parent" data-index="{{ $k }}">
                    <span class="add-mcq"><i class="fa fa-plus" aria-hidden="true"></i></span>

                    @if(property_exists($options, 'mcq'))
                        @foreach($options->mcq as $val)
                            <div class="col-md-3 mcq-field ">
                                <input type="radio" disabled class="form-field redio_btns">
                                <input type="text" name="form[{{ $k }}][options][mcq][]" class="form-field" placeholder="Label" value="{{ $val }}" />
                                <span class="remove-mcq"><i class="fa fa-minus" aria-hidden="true"></i></span>
                            </div>
                        @endforeach
                    @endif


                </div>
            </div>

            <div class="d-flex-cust">
                <div class="form-group w-50-cust">
                    <input type="text" name="form[{{ $k }}][options][placeholder]" placeholder="Placeholder" class="form-field" value="{{ (property_exists($options, 'placeholder')) ? $options->placeholder : '' }}" />
                </div>

                <div class="form-group Required_label w-50-cust">
                    <label>
                        <input type="checkbox" name="form[{{ $k }}][options][required]" @if(property_exists($options, 'required')) checked @endif class="form-control" value="1" />
                        Is Required?
                    </label>
                </div>
            </div>

            <span role="button" class="remove-field text-danger" data-removed="{{ $field->id }}">
                <i class="fa fa-minus" aria-hidden="true"></i> Remove
            </span>
        </div>
    @endforeach
@else
    @include('forms.includes.fields')
@endif