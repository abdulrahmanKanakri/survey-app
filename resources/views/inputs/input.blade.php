<div class="form-group">
    @if ($question->getType() == 'radio' || $question->getType() == 'checkbox')
        @if ($question->getType() == 'checkbox')
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
        @if($question->getType() == 'radio')
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
                    disabled
                ></textarea>
            @endif
        @endif
    @else
        @if ($question->getType() == 'textarea')
            <textarea 
                name="question[answer]" 
                class="form-control" 
                rows="5"
            ></textarea>
        @else
            @if ($question->getType() == 'range')
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
                    type="{{$question->getType()}}"
                    name="question[answer]" 
                    class="form-control"
                />
            @endif
        @endif
    @endif
</div>
