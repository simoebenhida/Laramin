@if(Session::has('Laramin_Toast'))
        <laramintoast :info="{{ Session::get('Laramin_Toast') }}"></laramintoast>
@endif
