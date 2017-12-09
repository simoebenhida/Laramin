<div id="laramin_image">
<formimagepreview src="@if(!empty($value)) {{ '/storage/'.laramin_get_active_menu()->first().'/'.$value }} @endif" name="{{ $name }}" errors="{{ $errors->first($name) }}"></formimagepreview>
</div>
