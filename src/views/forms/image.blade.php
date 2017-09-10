 <div class="column is-half">
         @if(!empty($value))
         <img src="{{ '/storage/'.laramin_get_active_menu()->first().'/'.$value }}">
         @endif
      <div class="field">
        <label for="{{ $name }}">{{ title_case($name) }}</label>
        <p class="control">
            <input type="file" class="input @if($errors->has($name)) is-danger @endif" name="{{ $name }}">
                 <p class="help is-danger">{{ $errors->first($name) }}</p>
        </p>
        </div>
</div>
