<div class="col-md-12 main-fields-div">
    <div class="form-group">
        <select name="type[]" class="form-field">
            <option value="">-- Select Field Type --</option>
            <option value="input">Input</option>
            <option value="textarea">Textarea</option>
            <option value="file">File</option>
            <option value="number">Number</option>
            <option value="tel">Telephone</option>
            <option value="email">Email</option>
            <option value="mcq">Multiple Choice Questions</option>
        </select>
    </div>
    
    <div class="form-group">
        <input type="text" name="label[]" placeholder="Label" class="form-field" />
    </div>

    <div class="form-group">
        <textarea disabled placeholder="test"></textarea>
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="required[]" class="form-field" />
            Is Required?
        </label>
    </div>

    <div class="form-group">
        <input type="text" name="placeholder[]" placeholder="Placeholder" class="form-field" />
    </div>

    <span role="button" class="remove-field text-danger">
        <i class="fa fa-minus" aria-hidden="true"></i> Remove
    </span>
</div>