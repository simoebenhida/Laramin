<div class="column is-2 menu-background" id="slblog_menu">
          {{-- /**

            TODO:
            - Menu Click Event For Later
           */ --}}

         <slblogthemenu :menus='{{ json_encode(slblog_menu_models()) }}' prefix="{{ config('SLblog.prefix') }}" active="{{ slblog_get_active_menu() }}"></slblogthemenu>
</div>

