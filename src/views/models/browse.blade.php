@extends('laramin::partials.main')

@section('title',$type->name)


@section('content')

    <div class="column is-12 m-t-100 m-b-200">
    <div class="columns">
    <div class="column is-6">
    <h1 class="title">{{ $type->name }}</h1>
    </div>
    <div class="column is-6">
         <a href="{{ route('laramin.' .$type->slug. '.create')}}" class="button is-primary is-pulled-right">
        <span class="icon">
          <i class="fa fa-plus"></i>
        </span>
        <span>Add {{ $type->name }}</span>
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

                @if($column->type == 'image' || $column->type == 'status')
                    @include('laramin::browse.'.$column->type,['infos' => $item[$column->column]])
                @else
                    <td>{{ str_limit($item[$column->column],20) }}</td>
                @endif
                @endforeach

                   <td class="pull-right">
                       <a href="{{ route('laramin.' .$type->slug. '.edit',$item->id)}}" class="button is-primary is-outlined">
                           <span>Edit</span>
                           <span class="icon is-small">
                               <i class="fa fa-pencil"></i>
                           </span>
                       </a>
                       <modeldelete link="{{ route('laramin.' .$type->slug. '.destroy',$item->id) }}" slug="{{ $type->name }}" token="{{ csrf_token() }}"></modeldelete>
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
