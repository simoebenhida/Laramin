@extends('slblog::partials.main')
@section('title','Register')

@section('content')

	<div class="columns">
  	<div class="column is-half is-offset-one-quarter m-t-100">
  		<div class="card">
  			<div class="card-content">
  				<h1 class="title">Log In</h1>
  				<form action="{{ route('register') }}" method="POST">

                        <div class="field">
                          <label>Name</label>
                          <p class="control">
                            <input type="text" class="input" placeholder="Name" name="name">
                          </p>
                        </div>

  				<div class="field">
  					<label>Email</label>
  					<p class="control">
  						<input type="email" class="input" placeholder="Email" name="email">
  					</p>
  				</div>

                        <div class="field">
                          <label>Password</label>
                          <p class="control">
                            <input type="password" class="input" placeholder="Password" name="password">
                          </p>
                        </div>

                           <div class="field">
                          <label>Password</label>
                          <p class="control">
                            <input type="password" class="input" placeholder="Password" name="password_confirmation">
                          </p>
                        </div>

                        <div class="field">
                             <button type="submit" class="button is-primary is-outlined is-fullwidth m-t-20">
                              Register
                            </button>
                        </div>

  				</form>
  			</div>
  		</div>
  	</div>
	</div>

@endsection