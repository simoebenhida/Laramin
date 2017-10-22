    <div class="field" style="min-height: 100px">
        <label class="label">{{ title_case($name) }}</label>
  <div class="control">
    <div class="select is-info is-multiple">
            <select name="{{ $name.'[]' }}" multiple size="8" style="min-height: 100px">
              @if($details !== NULL)
                @foreach(laramin_select_dropdown($details) as $detail)
              <option @if(old($name) == $detail->value || laramin_select_multiple_value($value)->contains($detail->value)) selected="selected" @endif value="{{ $detail->value }}">{{ $detail->option }}</option>
                @endforeach
               @endif
            </select>
        </div>
        </div>
    </div>
