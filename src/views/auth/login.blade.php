<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="{{ laramin_asset('css/bulma.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ laramin_asset('css/style.css') }}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <div class="column is-half is-offset-one-quarter m-t-100">
      <div class="card">
        <div class="card-content">
          <h1 class="title">Log In</h1>
         <form action="{{ route('laramin.postlogin') }}" method="POST">
                    {{ csrf_field() }}
          <div class="field">
              <label>Email</label>
                <p class="control">
                    <input type="email" class="input @if($errors->has('email')) is-danger @endif"  placeholder="Email" name="email" value="{{ old('email') }}">
                </p>
                <p class="help is-danger"> {{ $errors->first('email') }}</p>
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
</body>
</html>
