<div class="field" style="text-align: center">
                @if(Laramin::model('Category')->count() == 0)
                  <p class="help is-danger">You Need To Add A Category For Adding a Post</p>
                @else
        <label class="label">{{ title_case($name) }}</label>
        <div class="select is-primary">
             <select name="{{ $name }}">
                @foreach(Laramin::model('Category')->all() as $category)
                <option @if(old($name) == $category->id || $value == $category->id) selected="selected" @endif value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                @endforeach
            </select>
        </div>
            @endif
</div>
