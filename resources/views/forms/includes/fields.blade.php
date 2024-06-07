<div class="col-md-12 main-fields-div">
    <div class="form-group">
        <select name="form[0][type]" class="form-control select-field-type">
            <option value="">-- Select Field Type --</option>
            <option value="input">Input</option>
            <option value="password">Password</option>
            <option value="textarea">Textarea</option>
            <option value="file">File</option>
            <option value="number">Number</option>
            <option value="tel">Telephone</option>
            <option value="email">Email</option>
            <option value="mcq">Multiple Choice Questions</option>
        </select>
    </div>
    
    <div class="form-group">
        <input type="text" name="form[0][label]" placeholder="Label" class="form-control" />
    </div>

    <div class="form-group field-div">
        <textarea disabled class="form-control textarea hide" placeholder="Textarea"></textarea>
        <input type="file" disabled class="form-control file hide" />
        <input type="text" disabled class="form-control input hide" placeholder="Input" />
        <input type="text" disabled class="form-control password hide" placeholder="Password" />
        <input type="number" disabled class="form-control number hide" placeholder="Number" />
        <input type="tel" disabled class="form-control tel hide" placeholder="Telephone" />
        <input type="email" disabled class="form-control email hide" placeholder="Email" />

        <div class="mcq hide mcq-parent" data-index="0">
            <span class="add-mcq"><i class="fa fa-plus" aria-hidden="true"></i></span>
        </div>
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="form[0][options][required]" class="form-control" value="1" />
            Is Required?
        </label>
    </div>

    <div class="form-group">
        <input type="text" name="form[0][options][placeholder]" placeholder="Placeholder" class="form-control" />
    </div>

    <span role="button" class="remove-field text-danger">
        <i class="fa fa-minus" aria-hidden="true"></i> Remove
    </span>
</div>