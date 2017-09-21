 <div class="column is-half">
{{--  /**

     TODO:
     - Add Details To Select Dropdown and radio Button
     - Details Json on Data infos Update Vuejs Componenent

  */
 --}}
<div class="field m-t-20" style="text-align: center">
        <div class="select is-primary">
             <select name="{{ $name }}">
              @if($details !== NULL)
                @foreach(laramin_select_dropdown($details) as $detail)
               <option @if(old('status') == $detail->value || $value == $detail->value) selected="selected" @endif value="{{ $detail->value }}">{{ $detail->option }}</option>
                @endforeach
               {{-- <option @if(old('status') == 'PUBLISHED') selected="selected" @endif value="PUBLISHED">PUBLISHED</option>
              {{--  <option @if(old('status') == 'PENDING') selected="selected" @endif value="PENDING">PENDING</option>
               <option @if(old('status') == 'DRAFT') selected="selected" @endif value="DRAFT">DRAFT</option> --}}
               @endif
            </select>
        </div>
    </div>
</div>
