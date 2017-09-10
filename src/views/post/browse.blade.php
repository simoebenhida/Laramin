@extends('laramin::partials.main')

@section('title','Post')

@section('content')

	<div class="column is-12 m-t-100 m-b-200">
  	<div class="columns">
   	<div class="column is-6">
  	<h1 class="title">Posts</h1>
  	</div>
  	<div class="column is-6">
  		 <a class="button is-primary is-pulled-right">
	    <span class="icon">
	      <i class="fa fa-plus"></i>
	    </span>
	    <span>Add Posts</span>
	  </a>
  	</div>
	</div>

	<div class="card">
		<div class="card-content">
	<table id="dataTable">
	<thead>
		<tr>
		@foreach ($columns as $column)
			<th>{{ $column->column }}</th>
		@endforeach
		<th>Actions</th> {{-- The Same Action --}}
		</tr>
	</thead>
		<tbody>
			@foreach ($items as $item)
			<tr>
				@foreach ($columns as $column)
				{{-- Check If the column has access to display on Array Browse --}}
				@if($column->type == 'image' || $column->type == 'status')
					@include('laramin::browse.'.$column->type,['infos' => $item[$column->column]])
				@else
                                                @if($column->type == 'text' || $column->type == 'text_area')
				            <td>{{ str_limit($item[$column->column],10) }}</td>
                                                @else
                                                    <td>{{ $item[$column->column] }}</td>
                                                @endif
				@endif
				@endforeach
				{{-- <browseaction :items="{{ $item->toJson() }}"></browseaction> --}}
				   <td class="pull-right">
                                                    <a href="{{ route('laramin.models.edit',['type' => $type,'id' => $item->id])}}" class="button is-primary is-outlined">
                                                        <span>Edit</span>
                                                        <span class="icon is-small">
                                                          <i class="fa fa-pencil"></i>
                                                        </span>
                                                      </a>
                                                   <a class="button is-danger is-outlined">
                                                        <span>Delete</span>
                                                        <span class="icon is-small">
                                                          <i class="fa fa-times"></i>
                                                        </span>
                                                      </a>
                                                </td>
			</tr>
			@endforeach
		</tbody>
	</table>

  	</div>
  	</div>
  	</div>

@endsection
@section('scripts')
<script>
	$(document).ready(function () {
                $('#dataTable').DataTable();
        });
</script>
@endsection
