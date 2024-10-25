<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin | Lockscreen</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
        <!-- Toastr -->
        <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
    </head>
    <body class="hold-transition lockscreen">
        <!-- Automatic element centering -->
        <div class="lockscreen-wrapper">
            <div class="lockscreen-logo">
                <a href="#"><b>Quick </b>Line</a>
            </div>
            <!-- User name -->
            <div class="lockscreen-name">{{$user->name}}</div>

            <!-- START LOCK SCREEN ITEM -->
            <div class="lockscreen-item">
                <!-- lockscreen image -->
                <div class="lockscreen-image">
                    <img src="{!!$user->user_image!!}" alt="User Image">
                </div>
                <!-- /.lockscreen-image -->
                
                <!-- lockscreen credentials (contains the form) -->
                <form class="lockscreen-credentials" action="{{ route('2faVerify') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input id="one_time_password" autocomplete="off" name="one_time_password" class="form-control"  type="text" required/>
                        <div class="input-group-append">
                            <button type="submit" class="btn">
                                <i class="fas fa-arrow-right text-muted"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <!-- /.lockscreen credentials -->

            </div>
            <!-- /.lockscreen-item -->
            <div class="help-block text-center">
                <h2>Two Factor Authentication</h2>
                <h5>Enter the pin from Google Authenticator app</h5>
                Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.
            </div>
            <div class="lockscreen-footer text-center">
                Copyright &copy; 2023 <a href="#"> {{$site_name}}</a>.<br>
                All rights reserved
            </div>
        </div>
        <!-- /.center -->

        <!-- jQuery -->
        <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- Toastr -->
        <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
        <!-- SweetAlert2 -->
        <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
        
        <script type="text/javascript">
            $(function(){
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
               @php
                $msg = "";
               @endphp
               @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    @php
                        $msg = $error; 
                    @endphp
                    @endforeach

                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Quick Line',
                        subtitle: '',
                        body: '{{$msg}}',
                        autohide: true,
                        delay: 5000,
                    });
                @endif 
            });
        </script>
    </body>
</html>
