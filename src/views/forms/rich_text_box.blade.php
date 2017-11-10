        <div class="field">
                  <label for="{{ $name }}" class="label">{{ title_case($name) }}</label>
                    <textarea class="richTextBox @if($errors->has($name)) is-danger @endif" name="{{ $name }}">
                    @if(empty($value)){{ htmlentities(old($name)) }} @else {{ htmlentities($value) }}@endif
                    </textarea>
                     <p class="help is-danger">{{ $errors->first($name) }}</p>
        </div>
