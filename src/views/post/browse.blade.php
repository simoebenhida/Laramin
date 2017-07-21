@extends('slblog::partials.main')

@section('title','Post')

@section('content')

	<div class="columns">
	<div class="column"></div>
  	<div class="column is-10 m-t-100 m-b-100">

	<table id="dataTable">
	<thead>
		<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Author</th>
		<th>Status</th>
		<th>Image</th>
		<th></th>
		<th></th>
		</tr>
	</thead>
		<tbody>
		<tr>
			<td>1</td>
			<td>title</td>
			<td>author</td>
			<td>
				<span class="tag is-success">PUBLISHED</span>
				{{-- <span class="tag is-warning">PENDING</span>
				<span class="tag is-danger">DRAFT</span> --}}
			</td>
			<td>
				<img src="https://www.w3schools.com/css/trolltunga.jpg" style="height: 120px;width: 250px;">
			</td>
			<td>
				<a class="button is-primary is-outlined">
				    <span>Edit</span>
				    <span class="icon is-small">
				      <i class="fa fa-pencil"></i>
				    </span>
				  </a>
			</td>
			<td>
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
	<div class="column"></div>
  	</div>

@endsection
@section('scripts')
<script>
	$(document).ready(function () {
                $('#dataTable').DataTable();
        });
</script>
@endsection