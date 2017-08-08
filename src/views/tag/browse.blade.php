@extends('slblog::partials.main')

@section('title','Tags')

@section('content')

  	<div class="column is-12 m-t-100 m-b-200">
  	<div class="columns">
   	<div class="column is-6">
  	<h1 class="title">Tags</h1>
  	</div>
  	<div class="column is-6">
  		 <a class="button is-primary is-pulled-right">
	    <span class="icon">
	      <i class="fa fa-plus"></i>
	    </span>
	    <span>Add Tags</span>
	  </a>
  	</div>
	</div>
	<div class="card">
		<div class="card-content">
			<table id="dataTable">
	<thead>
		<tr>
		<th>ID</th>
		<th>name</th>
		<th>created at</th>
		<th>Actions</th>
		</tr>
	</thead>
		<tbody>
		<tr>
			<td>1</td>
			<td>name</td>
			<td>2017-07-06 13:18:47</td>
			<td class="pull-right">
				<a class="button is-primary is-outlined">
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