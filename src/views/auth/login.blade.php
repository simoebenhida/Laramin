@extends('slblog::partials.main')
@section('title','LogIn')

@section('content')

	<div class="columns">
  	<div class="column is-half is-offset-one-quarter m-t-100">
  		<div class="card">
  			<div class="card-content">
  				<h1 class="title">Log In</h1>
                    <form action="{{ route('login') }}" method="POST">
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
                             <button type="submit" class="button is-primary is-outlined is-fullwidth m-t-20">
                              Login
                            </button>
                        </div>
  				</form>
  			</div>
  		</div>
  	</div>
	</div>

@endsection