@extends('slblog::partials.main')

@section('title','Manage Permission')

@section('content')
<h1 class="is-center m-t-100 m-b-20">Manage Permission For Simo</h1>

    <div class="card">
        <div class="card-content">

        <div class="column is-4">
        <h3>Role</h3>
        <select class="input" name="role">
            <option>roles</option>
        </select>
        </div>

          <div class="column is-4">
        <h3 class="m-t-20 m-b-20">Permission</h3>

         <label class="checkbox m-b-20">
                          <input type="checkbox">
                          Select All
         </label>
        </div>

        <div class="columns is-multiline">
        @foreach(SLblog::getAllModels() as $key => $model)
                <div class="column is-one-quarter">
           <ul>
               <li>
               <p> - <strong>{{ $key }}</strong></p>
               <ul style="margin-left: 30px">
                   <li>
                       <label class="checkbox">
                          <input type="checkbox">
                          create
                        </label>
                    </li>
                    <li>
                       <label class="checkbox">
                          <input type="checkbox">
                          read
                        </label>
                    </li>
                    <li>
                       <label class="checkbox">
                          <input type="checkbox">
                          update
                        </label>
                    </li>
                     <li>
                       <label class="checkbox">
                          <input type="checkbox">
                          delete
                        </label>
                    </li>
               </ul>
               </li>
           </ul>
             </div>
           @endforeach
            </div>
            <button class="button is-primary">Save</button>
        </div>
    </div>
@endsection
