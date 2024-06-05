<div>
    <!-- Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

</div>
@extends('layouts.app')

@section('title', 'Edit Assessment')

<!-- page content -->
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @if(isset($errors))
                @if ( count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif

            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Assessment</h2>

                    @if(auth()->user()->user_type == 3)
                        <a href="{{route('assessments-list')}}" class="btn btn-primary" style="float:right;" title="Back">Back</a>
                    @elseif(auth()->user()->user_type == 2)
                        <a href="{{ route('assessment-list') }}" class="btn btn-primary" style="float:right;">Back</a>
                    @endif
                

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <!-- Your form fields go here -->
                    <form action="{{ route('update-assessment', $assessment->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="hidden" id="title" name="id" class="form-control"  value="{{$assessment->id}}" required>
                            <input type="text" id="title" name="title" class="form-control"  value="{{$assessment->title}}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" required>{{$assessment->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <input type="date" id="due_date" name="due_date" class="form-control" value="{{$assessment->due_date}}" required>
                        </div>

                        @if(!empty($questions) && count($questions) > 0)
                            <div class="form-group" style="margin-top:20px;">
                                <h3 class="text-center">Added Questions</h3>
                            </div>
                        @endif

                        @foreach($questions as $question)
                            <div class="form-group">
                                <label for="date_created">Question:</label><button class="btn btn-danger btn-sm delete-question mt-5" data-question-id="{{$question->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                <input type="text" name="questions[{{$question->id}}][question]" value="{{$question->question}}" class="form-control" required>
                                <input type="hidden" name="questions[{{$question->id}}][id]" value="{{$question->id}}" class="form-control" required>
                                    @if($question->question_type == "radio")
                                    <label for="date_created">Options:</label>
                                    <?php
                                        $answers = explode(',', $question['answer']);
                                    ?>
                                    @foreach($answers as $answer)
                                        <input type="text" name="questions[{{$question->id}}][options][]" value="{{$answer}}" class="form-control" required>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach

                        <!-- Add Question -->
                        <div id="questions-container"></div>
                        <!-- End add question -->
                        
                        <button type="button" class="btn btn-primary mt-3" onclick="addQuestion('input')">Add Short Question</button>
                        <button type="button" class="btn btn-primary mt-3" onclick="addQuestion('textarea')">Add Long Question</button>
                        <button type="button" class="btn btn-primary mt-3" onclick="addQuestion('radio')">Add Multiple Choice Question</button>

                        <button type="submit" class="btn btn-primary" style="display: block;">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('.delete-question').click(function(e) {
            e.preventDefault();
            var questionId = $(this).data('question-id');
            console.log('Delete button clicked for question ID:', questionId);
            if (confirm("Are you sure you want to delete this question?")) {
                $.ajax({
                    type: 'DELETE',
                    url: '{{ route("destroy-questions", ["id" => ":id"]) }}'.replace(':id', questionId),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Server response:', response);
                        if (response.success) {
                            // Remove the question element from the DOM
                            $(e.target).closest('.form-group').remove();
                            // alert('Question deleted successfully.');
                        } else {
                            alert('Error: ' + response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        alert('Error: ' + xhr.responseText);
                    }
                });
            }
        });
    });
</script>

@stop

@section('scripts')
    <!-- Include your JavaScript if needed -->

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
