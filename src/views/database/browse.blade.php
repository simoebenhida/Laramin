
@extends('slblog::partials.main')

@section('title','DaTabase')

@section('content')

    <div class="column is-12 m-t-100 m-b-200">
    <div class="columns">
    <div class="column is-6">
    <h1 class="title">DaTabase</h1>
    </div>
    <div class="column is-6">
         <a href="/{{ config('SLblog.prefix') }}/database/create" class="button is-primary is-pulled-right">
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
        <th>created at</th>
        <th class="pull-right">Actions</th>
        </tr>
    </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>Name</td>
            <td>Model Name</td>
            <td>slug</td>
            <td>2017-07-06 13:18:47</td>
            <td class="pull-right">
            {{--     /**
                    TODO:
                    - Add PopUp Showing Column Models With Types
                 */ --}}
               <a class="button is-primary is-outlined">
                    <span>Show Columns</span>
                    <span class="icon is-small">
                      <i class="fa fa-pencil"></i>
                    </span>
                  </a>
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
