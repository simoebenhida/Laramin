@extends('laramin::partials.main')

@section('title','DaTabase')

@section('content')

    <div class="column is-12 m-t-100 m-b-200">
    <div class="columns">
    <div class="column is-6">
    <h1 class="title">DaTabase</h1>
    </div>
    <div class="column is-6">
        @if(Auth::user()->can('create-databases'))
         <a href="/{{ config('laramin.prefix') }}/database/create" class="button is-primary is-pulled-right">
        <span class="icon">
          <i class="fa fa-plus"></i>
        </span>
        <span>Add Databse</span>
      </a>
      @endif
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

                @if(Auth::user()->can('read-databases'))
                <columndatabase :columns="{{ $type->infos }}"></columndatabase>
                @endif

                @if(Auth::user()->can('update-databases'))
                <a href="/{{ config('laramin.prefix') }}/database/edit/{{ $type->id }}" class="button is-primary is-outlined">
                    <span>Edit</span>
                    <span class="icon is-small">
                      <i class="fa fa-pencil"></i>
                    </span>
                  </a>
                @endif

                @if(Auth::user()->can('delete-databases'))
                <a href="{{ route('laramin.database.destroy',$type->id) }}" class="button is-danger is-outlined">
                    <span>Delete</span>
                    <span class="icon is-small">
                      <i class="fa fa-times"></i>
                    </span>
                  </a>
                  @endif
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
