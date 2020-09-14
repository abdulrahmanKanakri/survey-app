<div class="form-group">
    @if ($question->type == 'radio' || $question->type == 'checkbox')
        @if ($question->type == 'checkbox')
            <input 
                id="answer_{{$answer->id}}" 
                type="checkbox" 
                name="question[answers][]" 
                value="{{$answer->body}}"
            />
            <label for="answer_{{$answer->id}}" class="ml-1">
                {{$answer->body}}
            </label>
        @endif
        @if($question->type == 'radio')
            <input 
                id="answer_{{$answer->id}}" 
                type="radio" 
                name="question[answer]" 
                value="{{$answer->body}}"
            />
            <label for="answer_{{$answer->id}}" class="ml-1">
                {{$answer->body}}
            </label>
            @if ($answer->body == 'other')
                <textarea 
                    name="question[answer]" 
                    class="form-control d-none" 
                    id="textarea-other"
                    placeholder="Write your answer here.."
                ></textarea>
            @endif
        @endif
    @else
        @if ($question->type == 'textarea')
            <textarea 
                name="question[answer]" 
                class="form-control" 
                rows="5"
            ></textarea>
        @else
            @if ($question->type == 'range')
                <input 
                    type="range"
                    name="question[answer]" 
                    style="width: 100%"
                    min="0" 
                    max="100"
                    step="10" 
                />
            @else
                <input 
                    type="{{$question->type}}"
                    name="question[answer]" 
                    class="form-control"
                />
            @endif
        @endif
    @endif
</div>
