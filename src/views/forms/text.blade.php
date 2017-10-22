 <div class="field">
            <label for="{{ $name }}" class="label">{{ title_case($name) }}</label>
            <p class="control">
                <input type="text" @if($name == 'slug') data-slug-origin="title" @endif id="{{ $name }}" class="input @if($errors->has($name)) is-danger @endif" placeholder="{{ title_case($name) }}" name="{{ $name }}"
                value="@if(empty($value)){{ old($name)}}@else{{ $value }}@endif">
            </p>
             <p class="help is-danger">{{ $errors->first($name) }}</p>
</div>
