
<div class="field" style="text-align: center">
        <label class="label">{{ title_case($name) }}</label>
        <div class="select is-primary">
             <select name="{{ $name }}">
              @if($details !== NULL)
                @foreach(laramin_select_dropdown($details) as $detail)
               <option @if(old($name) == $detail->value || $value == $detail->value) selected="selected" @endif value="{{ $detail->value }}">{{ $detail->option }}</option>
                @endforeach
               @endif
            </select>
        </div>
    </div>
