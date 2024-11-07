<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="utf-8">
		<title>Quick Line | Change Password</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- LINEARICONS -->
		<link rel="stylesheet" href="{{ asset('fonts/linearicons/style.css')}}">
		
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <style>
      h3 {
        margin-bottom: 10px;
      }
      h5{
        margin-bottom: 33px;
        color: #444;
        font-family: "Muli-SemiBold"
      }
    </style>
	</head>
    <body>
		<div class="wrapper">
			<div class="inner">
				<img src="{{ asset('images/image-1.png')}}" alt="" class="image-1">
				<form name="change_password_form" action="{{ route('admin.updatePassword') }}" method="post">
            @csrf
            <h3>Change Password</h3>
            <h5>You are log-in using a Default Password, Change the password to Continue.</h5>
            <div class="form-holder">
              <span class="lnr lnr-lock"></span>
              <input type="password" name="password" class="form-control" placeholder="New Password">
            </div>
            <div class="form-holder">
              <span class="lnr lnr-lock"></span>
              <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
            </div>
            <button>
              <span>Change Password</span>
            </button>
            <input type="hidden" name="r" value="{{$r}}" />
            <div class="form-holder">
                <p class="mb-1" style="float: right"><a href="{{ route('admin.dashboard') }}">Update Password Later</a></p>
					  </div>
				</form>
                
				<img src="{{ asset('images/image-2.png')}}" alt="" class="image-2">
			</div>
		</div>
		
		<script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>
		<script src="{{ asset('js/main.js')}}"></script>
		<script src="{{ URL::asset('plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
		@if(session('error'))
			<script>
				Swal.fire({
					title: 'Error!',
					html: "{{ session('error') }}",
					icon: 'error',
					confirmButtonText: 'Close',
					timer: 5000,
					timerProgressBar: true
				});
			</script>
		@endif
    @if ($errors->any())
			<script>
				let errorMessages = `
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				`;
				Swal.fire({
					title: 'Error!',
					html: errorMessages,
					icon: 'error',
					confirmButtonText: 'Close',
					timer: 10000,
					timerProgressBar: true,
				});
			</script>
		@endif
	</body>
</html>