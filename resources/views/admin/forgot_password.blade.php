<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<title>Quick Line | Forgot Password</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- LINEARICONS -->
		<link rel="stylesheet" href="{{ asset('fonts/linearicons/style.css')}}">
		
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="{{ asset('css/style.css')}}">
	</head>
  <body>
		<div class="wrapper">
			<div class="inner">
				<img src="{{ asset('images/image-1.png')}}" alt="" class="image-1">
				<form name="admin_login_form" action="{{ route('admin.forgot_password') }}" method="post">
          @csrf
					<h3>Forgot Password</h3>
          <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
					<div class="form-holder">
						<span class="lnr lnr-envelope"></span>
						<input type="email" name="email" class="form-control" placeholder="Email">
					</div>
					<button>
						<span>Submit</span>
					</button>
            <div class="form-holder">
            <a href="{{ route('admin.login') }}">Login</a>
					</div>
				</form>
                
				<img src="{{ asset('images/image-2.png')}}" alt="" class="image-2">
			</div>
		</div>
		
		<script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>
		<script src="{{ asset('js/main.js')}}"></script>
	</body>
</html>