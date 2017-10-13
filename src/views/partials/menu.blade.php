<div class="column is-2">
         <laraminthemenu
         :menus='{{ json_encode(laramin_menu_models()) }}'
         prefix="{{ config('Laramin.prefix') }}"
         :active="{{ json_encode(laramin_get_active_menu()) }}"
         :permission="{{ json_encode(laramin_read_permission_menu()) }}"></laraminthemenu>
</div>

