 <div class="column is-half">
 <div class="field m-t-40" style="text-align: center">
         <label class="checkbox">
          <input type="checkbox" name="{{ $name }}" value="1" @if($value == '1') checked @endif>
          {{ title_case($name) }}
        </label>
</div>
</div>
