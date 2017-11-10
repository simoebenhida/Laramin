<div class="field" id="tagsvue" style="min-height: 100px">
  <div class="control">
        <label class="label">{{ title_case($name) }}</label>
            <tagselect :tags="{{ Laramin::model('Tag')->details() }}" nameinput="{{ $name }}" :old="{{ laramin_get_tags($id,laramin_get_active_menu()->first()) }}"></tagselect>
        </div>
    </div>
