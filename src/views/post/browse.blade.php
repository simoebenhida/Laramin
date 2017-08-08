@extends('slblog::partials.main')

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
		<th>ID</th>
		<th>Title</th>
		<th>Author</th>
		<th>Image</th>
		<th>created at</th>
		<th>Status</th>
		<th>Actions</th>
		</tr>
	</thead>
		<tbody>
		<tr>
			<td>1</td>
			<td>title</td>
			<td>author</td>
			<td>
				<img src="https://www.w3schools.com/css/trolltunga.jpg" style="width:100px">
			</td>
			<td>2017-07-06 13:18:47</td>
			<td>
				<span class="tag is-success">PUBLISHED</span>
				{{-- <span class="tag is-warning">PENDING</span>
				<span class="tag is-danger">DRAFT</span> --}}
			</td>
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