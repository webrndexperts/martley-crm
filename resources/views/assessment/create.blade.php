@extends('layouts.app')

@section('title', 'Create Clinical Assessment')

<!-- page content -->
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            {{-- Include error and success messages --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="x_panel">
                <div class="x_title">
                    <h2>Create Assessment</h2>
                    <a href="{{route('assessment-list')}}" class="btn btn-primary" style="float:right;" title="Back">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                    </a>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <form action="{{ route('save.assessment') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" value="{{ old('title') }}" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter description">{{ old('description') }}</textarea>
                        </div>

                        @if(Auth::user()->user_type == '3')
                            <div class="form-group">
                                <label for="due_date">Due Date</label>
                                <input type="date" id="due_date" name="due_date" value="{{ old('due_date') }}"  class="form-control" required>
                            </div>
                        @endif

                            <!-- Add Question -->

                            <div id="questions-container"></div>

                            <!-- End add question -->

                        <button type="button" class="btn btn-primary mt-3" onclick="addQuestion('input')">Add Short Question</button>
                        <button type="button" class="btn btn-primary mt-3" onclick="addQuestion('textarea')">Add Long Question</button>
                        <button type="button" class="btn btn-primary mt-3" onclick="addQuestion('radio')">Add Multiple Choice Question</button>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="display: block;" title="Submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>

    function addQuestion(questionType) {
        let questionCount = document.querySelectorAll('#questions-container .form-group').length;
        questionCount++;
        const questionContainer = document.getElementById('questions-container');
        const newQuestionDiv = document.createElement('div');
        newQuestionDiv.classList.add('form-group', 'mb-3');
        newQuestionDiv.innerHTML = `
            <label for="question">Question ${questionCount}</label> <button type="button" class="btn btn-danger" onclick="removeQuestion(this)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
            <input type="text" name="questions[${questionCount}][question]" class="form-control mb-2" placeholder="Enter question" required>
            <input type="hidden" name="questions[${questionCount}][type]" value="${questionType}" required>
        `;
        if (questionType === 'radio') {
            newQuestionDiv.innerHTML += `
                <div class="options-container">
                    <label for="options_${questionCount}">Options:</label>
                    <input type="text" name="questions[${questionCount}][options][]" class="form-control mb-2" placeholder="Option 1" required>
                    <input type="text" name="questions[${questionCount}][options][]" class="form-control mb-2" placeholder="Option 2" required>
                </div>

                <button type="button" class="btn btn-secondary mt-2" onclick="addOption(this)">Add Option</button>
            `;
        }
        questionContainer.appendChild(newQuestionDiv);
    }

    function addOption(button) {
        const optionsContainer = button.previousElementSibling;
        const newOptionInput = document.createElement('input');
        newOptionInput.type = 'text';
        newOptionInput.name = optionsContainer.querySelector('input').name;
        newOptionInput.className = 'form-control mb-2';
        newOptionInput.placeholder = 'Enter option';
        newOptionInput.required = true;
        optionsContainer.appendChild(newOptionInput);
    }

    function removeQuestion(button) {
        const questionDiv = button.parentElement;
        questionDiv.remove();
    }

</script>

@stop

@section('scripts')

<script>
	ClassicEditor.create( document.querySelector( '#description' ) )
	.then(editor => {
		editor.ui.focusTracker.on('change:isFocused', (evt, propertyName, newValue, oldValue) => {
			if (newValue) {
				editor.ui.getEditableElement().style.height = '100px';
			}
		});
	})
		.catch( error => {
			console.error( error );
		} );
</script>

@stop
