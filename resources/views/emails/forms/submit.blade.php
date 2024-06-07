<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{{ $form->name }} Answers</title>
	</head>
	<body>
		<h2>{{ $form->name }}</h2>

		@if($answers && count($answers) > 0)

			<p>Submitted By: {{ $answers[0]->user->name }}</p>

		    @foreach($answers as $k => $answer)
		        <div class="answer-div">
		            <label>{{ $answer->question->label }}</label>

		            @if($answer->question->type == 'file')
		                <a class="file-type" href="{{ $answer->answer }}" target="_blank">View</a>
		            @elseif($answer->question->type == 'mcq')
		                <?php $options = json_decode($answer->question->options); ?>

		                @if(property_exists($options, 'mcq'))
		                    <div class="mcq-options">
		                        @foreach($options->mcq as $val)
		                            <span>{{ $val }}</span>
		                        @endforeach
		                    </div>
		                @endif

		                <span class="answer">{{ $answer->answer }}</span>
		            @else
		                <span class="answer">{{ $answer->answer }}</span>
		            @endif
		        </div>
		    @endforeach
		@endif
	</body>
</html>