<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="utf-8">
		<title>Quick Line | Log In</title>
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
				<form name="admin_login_form" action="{{ route('admin.login') }}" method="post">
                    @csrf
					<h3>Quick Line Log in</h3>
					<div class="form-holder">
						<span class="lnr lnr-envelope"></span>
						<input type="email" name="email" class="form-control" placeholder="Email">
					</div>
					<div class="form-holder">
						<span class="lnr lnr-lock"></span>
						<input type="password" name="password" class="form-control" placeholder="Password">
					</div>
                    <div class="form-holder">
                        <input type="checkbox" id="remember" name="remember" checked> Remember Me
					</div>
					<button>
						<span>Log In</span>
					</button>
                    <input type="hidden" name="r" value="{{$r}}" />
                    <div class="form-holder">
                        <p class="mb-1"><a href="{{ route('forgot_password') }}">I forgot my password</a></p>
					</div>
				</form>
                
				<img src="{{ asset('images/image-2.png')}}" alt="" class="image-2">
			</div>
		</div>
		
		<script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>
		<script src="{{ asset('js/main.js')}}"></script>
	</body>
</html>