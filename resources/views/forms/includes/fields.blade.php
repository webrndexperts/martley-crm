<div class="col-md-12 main-fields-div">
    <div class="d-flex-cust">
        <div class="form-group w-50-cust">
            <select name="form[0][type]" class="form-field select-field-type">
                <option value="">-- Select Field Type --</option>
                <option value="checkbox">Checkbox</option>
                <option value="email">Email</option>
                <option value="file">File</option>
                <option value="input">Input</option>
                <option value="mcq">Multiple Choice Questions</option>
                <option value="number">Number</option>
                <option value="tel">Telephone</option>
                <option value="textarea">Textarea</option>
            </select>
        </div>
        
        <div class="form-group w-50-cust">
            <input type="text" name="form[0][label]" placeholder="Label" class="form-field" />
        </div>
    </div>

    <div class="form-group field-div">
        <div class="mcq hide mcq-parent" data-index="0">
            <span class="add-mcq"><i class="fa fa-plus" aria-hidden="true"></i></span>
        </div>
    </div>

    <div class="d-flex-cust">
        <div class="form-group w-50-cust">
            <input type="text" name="form[0][options][placeholder]" placeholder="Placeholder" class="form-field" />
        </div>
        
        <div class="form-group Required_label w-50-cust">
            <label>
                <input type="checkbox" name="form[0][options][required]" class="form-control" value="1" />
                Is Required?
            </label>
        </div>
    </div>

    <span role="button" class="remove-field text-danger">
        <i class="fa fa-close" style="font-size:20px"></i>
    </span>
</div>