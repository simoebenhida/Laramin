 <div class="column is-half">
 <div class="field">
            <label for="{{ $name }}" class="label">{{ title_case($name) }}</label>
            <p class="control">
                <input type="number" id="{{ $name }}" class="input @if($errors->has($name)) is-danger @endif" placeholder="{{ title_case($name) }}" name="{{ $name }}" value="{{ old($name)}}">
            </p>
             <p class="help is-danger">{{ $errors->first($name) }}</p>
</div>
</div>
