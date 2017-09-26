 <div class="column is-half">
         @if(!empty($value))
         <img src="{{ '/storage/'.laramin_get_active_menu()->first().'/'.$value }}">
         @endif

            <div class="field">
              <label for="{{ $name }}" class="label">{{ title_case($name) }}</label>
              <div class="file is-centered is-boxed is-success has-name">
                <input class="input" type="file" class="@if($errors->has($name)) is-danger @endif" name="{{ $name }}">
              </div>
                     <p class="help is-danger">{{ $errors->first($name) }}</p>
            </div>

</div>
