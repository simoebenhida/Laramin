 <div class="column is-half">
<div class="field">
          <label for="{{ $name }}" class="label">{{ title_case($name) }}</label>
            <textarea class="textarea @if($errors->has($name)) is-danger @endif" rows="4" name="{{ $name }}">@if(empty($value)){{ old($name)}}@else{{ $value }}@endif</textarea>
             <p class="help is-danger">{{ $errors->first($name) }}</p>
        </div>
</div>
