<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="_token" content="{!! csrf_token() !!}" />
  <title>Admin | @yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- Select 2 -->
  <link rel="stylesheet"  href="{{asset('dist/css/select2.min.css')}}" />
  <!-- Date Range Picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">

  <style type="text/css">
    .timeline-user-image{
      width: 30px;
      margin-right: 11px;
    }
  </style>
  @yield('extra_css')
</head>
<body class="hold-transition light-mode sidebar-dark-purple  sidebar-collapse sidebar-mini-md text-sm accent-blue">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="{{asset('dist/img/quick_on_small_icon.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{Route('admin.dashboard')}}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.logout')}}" class="nav-link">Logout</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge @if($case_count >5) badge-danger @elseif($case_count <5 && $case_count>0) badge-warning @endif navbar-badge">{{ $case_count }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{ $case_count }} New Case(s)</span>
          <div class="dropdown-divider"></div>
          <a href="{{ $caseStudiesUrl }}" class="dropdown-item">
            <i class="fas fa-info-circle mr-2 text-danger"></i> {{ $emergencyCaseCount }} Emergency Case(s)
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ $caseStudiesUrl }}" class="dropdown-item">
            <i class="fas fa-notes-medical mr-2 text-warning"></i> {{ $normalCaseCount }} Normal Case(s)
          </a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-cog"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-purple elevation-4">
    <!-- Brand Logo -->
    <a href="{{Route('admin.dashboard')}}" class="brand-link">
      <img src="{{asset('dist/img/quick_on_small_icon.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Quick Line</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{!!$user->user_image!!}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{$user->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        @include("admin.includes.sideMenu")
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2023 <a href="#"> {{$site_name}}</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- Select 2 -->
<script src="{{asset('dist/js/select2.min.js')}}"></script>
<!-- Date Range Picker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Input Mask -->
<script src="{{asset('plugins/inputmask/jquery.inputmask.min.js')}}"></script>

<script type="text/javascript">
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        @if(isset($formFields))
          @foreach ($formFields as $formField)
            @if($formField->FormField->element_type == "multiselect")
              $('#{{$formField->FormField->field_name}}').select2();
            @elseif($formField->FormField->element_type == "phone")
              $('#{{$formField->FormField->field_name}}').inputmask({
                mask: "9999-999-999",
                prefix: "+91 ",
                placeholder: "____-___-___",           // Optional: use space as placeholder
                showMaskOnHover: true,      // Don't show mask when not focused
                showMaskOnFocus: true,       // Show mask on focus
                onincomplete: function () {
                    $(this).val('');         // Clear field if input is incomplete
                }
              });
            @elseif($formField->FormField->element_type == "date")
              $('#{{$formField->FormField->field_name}}').daterangepicker({
                singleDatePicker: true,
                locale: {
                  format: 'DD/MM/YYYY'
                }
              });
            @elseif($formField->FormField->element_type == "datetime")
              $('#{{$formField->FormField->field_name}}').daterangepicker({
                  singleDatePicker: true,
                  timePicker: true,
                  timePickerIncrement: 30,
                  locale: {
                    format: 'DD/MM/YYYY hh:mm A'
                  }
                });
            @endif
          @endforeach
        @endif
    });
    (function ($) {
        'use strict'

        var $sidebar = $('.control-sidebar')
        var $container = $('<div />', {
          class: 'p-3 control-sidebar-content'
        });

        $sidebar.append($container)

        // Checkboxes

        $container.append(
          '<h5>Settings</h5><hr/>'
        );

        $container.append(
            '<div class="mb-4"><i class="fas fa-key">&nbsp</i><a href="{{Route("2fa")}}">Two Factor Authentication</a></div>'
        );

        $container.append(
            '<div class="mb-1"><i class="fas fa-sign-out-alt">&nbsp</i><a href="{{ route("admin.logout")}}">Logout</a></div>'
        );
    })(jQuery);
    
    @if(Session::has('infomsg'))
        @php
            $msg = Session::get('infomsg');
        @endphp
    
    $(document).Toasts('create', {
        class: 'bg-info',
        title: 'Information',
        subtitle: {{$site_name}},
        body: {{$msg}},
    });
    @endif
</script>
<script src="{{ URL::asset('plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>

<script type="text/javascript">
    <?php
        if($errors->any())
        {
            $msg = "";
            foreach ($errors->all() as $error){
                $msg .= $error."<br/>";
            }
        ?>
            Swal.fire({
                title: 'Error!',
                html: "<?= $msg ?>",
                icon: 'error',
                confirmButtonText: 'Close',
                timer: 5000,
                timerProgressBar: true
            });
    <?php }?>
    
    <?php
        if(Session::has('infomsg'))
        {
            $msg = Session::get('infomsg');
    ?>
        /*=============== FOR INFORMATION MESSAGE =============*/
        Swal.fire({
            title: 'Information.',
            html: "<?= $msg ?>",
            icon: 'info',
            confirmButtonText: 'Close',
            timer: 5000,
            timerProgressBar: true,
        });
        /*=============== FOR INFORMATION MESSAGE =============*/
    <?php }?>
    
    function printErrorMsg(msg) {
        allMsg = "<div style='text-align: left; margin: 0 0 0 35px;'><ul>";
        $.each(msg, function (key, value) {
            var element = $("#"+key);
            if(!element.is('input[type=file]')){
                $("#"+key).addClass('is-invalid');
                $("#"+key).after("<span id='"+key+"_error' class='error invalid-feedback'>"+value+"</span>");
            }
            allMsg += ("<li>&nbsp;" + value + "</li>");
        });
        allMsg += '</ul></div>';

        Swal.fire({
            title: 'Error!',
            html: allMsg,
            icon: 'error',
            confirmButtonText: 'Close',
            timer: 10000,
            timerProgressBar: true,
        });
    }

    function printSuccessMsg(msg) {
        Swal.fire({
            title: 'Great!',
            html: msg,
            icon: 'success',
            confirmButtonText: 'Close',
            timer: 5000,
            timerProgressBar: true,
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                location.reload();
            }
        });
    }
    
    function scrollToAnchor(aid){
        var aTag = $("a[name='"+ aid +"']");
        $('html,body').animate({scrollTop: aTag.offset().top},'slow');
    }
</script>
@yield('extra_js')
</body>
</html>
