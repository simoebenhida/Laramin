 <div class="column is-half">
 <div class="field">
            <label for="{{ $name }}">{{ title_case($name) }}</label>
            <p class="control">
                <input type="text" id="{{ $name }}" class="input @if($errors->has($name)) is-danger @endif" placeholder="{{ title_case($name) }}" name="{{ $name }}"
                value="@if(empty($value)){{ old($name)}}@else{{ $value }}@endif">
            </p>
             <p class="help is-danger">{{ $errors->first($name) }}</p>
</div>
</div>
