 <div class="field m-t-40" style="text-align: center">
         <label class="checkbox label">
          <input type="checkbox" name="{{ $name }}" value="1" @if($value == '1') checked @endif>
          {{ title_case($name) }}
        </label>
</div>
