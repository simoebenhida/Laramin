
@extends('laramin::partials.main')

@section('title','DaTabase')

@section('content')

    <div class="column is-12 m-t-100 m-b-200">
    <div class="columns">
    <div class="column is-6">
    <h1 class="title">DaTabase</h1>
    </div>
    <div class="column is-6">
         <a href="/{{ config('Laramin.prefix') }}/database/create" class="button is-primary is-pulled-right">
        <span class="icon">
          <i class="fa fa-plus"></i>
        </span>
        <span>Add Databse</span>
      </a>
    </div>
    </div>

    <div class="card">
        <div class="card-content">
    <table id="dataTable">
    <thead>
        <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Model Name</th>
        <th>Slug</th>
        <th>Menu</th>
        <th>created at</th>
        <th class="pull-right">Actions</th>
        </tr>
    </thead>
        <tbody>
        @foreach (Laramin::model('DataType')->all() as $type)
        <tr>
            <td>{{ $type->id }}</td>
            <td>{{ $type->name }}</td>
            <td>{{ $type->model }}</td>
            <td>{{ $type->slug }}</td>
            <td>{{ $type->menu }}</td>
            <td>{{ $type->created_at }}</td>
            <td class="pull-right">
            {{--     /**
                    TODO:
                    - Add PopUp Showing Column Models With Types
                 */ --}}
                <columndatabase :columns="{{ $type->infos }}"></columndatabase>
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
