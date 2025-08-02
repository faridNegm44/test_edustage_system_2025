<!DOCTYPE html>
	<html lang="ar" dir="rtl">
<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Dashfox - Laravel Admin & Dashboard Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords" content="admin template, admin dashboard, bootstrap dashboard template, bootstrap 4 admin template, laravel, php framework, php laravel, laravel framework, php mvc, laravel admin panel, laravel admin panel, laravel template, laravel bootstrap, blade laravel, best php framework"/>
    <title> Forget Password </title>
    <link rel="icon" href="{{ asset('back') }}/assets/img/brand/favicon.png" type="image/x-icon"/>
		<link href="{{ asset('back') }}/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />
		<link href="{{ asset('back') }}/assets/plugins/icons/icons.css" rel="stylesheet">
		<link href="{{ asset('back') }}/assets/plugins/sidebar/sidebar.css" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('back') }}/assets/css-rtl/sidemenu.css">
		<link href="{{ asset('back') }}/assets/css-rtl/style.css" rel="stylesheet">
		<link href="{{ asset('back') }}/assets/css-rtl/style-dark.css" rel="stylesheet">
		<link id="theme" href="{{ asset('back') }}/assets/css-rtl/colors/color.css" rel="stylesheet">
		<link href="{{ asset('back') }}/assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />
		<link href="{{ asset('back') }}/assets/plugins/jqvmap/jqvmap.min.css" rel="stylesheet">
        <link href="{{ asset('back') }}/assets/plugins/jqvmap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
		<link href="{{ asset('back') }}/assets/css-rtl/skin-modes.css" rel="stylesheet" />
		<link href="{{ asset('back') }}/assets/css-rtl/animate.css" rel="stylesheet">
		<link href="{{ asset('back') }}/assets/switcher/css/switcher-rtl.css" rel="stylesheet">
		<link href="{{ asset('back') }}/assets/switcher/demo.css" rel="stylesheet">
		<link href="{{ asset('back') }}/assets/plugins/notify/css/notifIt.css" rel="stylesheet"/>

		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

		@yield('header')
</head>

    <body class="main-body light-theme">

		<!-- Loader -->
		<div id="global-loader">
			<img src="{{ asset('back') }}/assets/img/loader-2.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<div class="my-auto page page-h">
			
            		
        
			<!-- Main-signin-wrapper -->
			<div class="my-auto page">
				<div class="main-signin-wrapper error-wrapper">
					<div class="main-card-signin forgot-password d-md-flex wd-100p">
						<div class="wd-md-50p  page-signin-style p-md-5 p-4 text-white d-none d-md-block ">
							<div class="my-auto authentication-pages">
								<div>
									<img src="{{ asset('back') }}/images/settings/logo.png" class=" m-0 mb-4" alt="logo">
									{{-- <h5 class="mb-4">Responsive Modern Dashboard &amp; Admin Template</h5>
									<p class="mb-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
									<a href="index-2.html" class="btn btn-danger">Learn More</a> --}}
								</div>
							</div>
						</div>
						<div class="p-5 wd-md-50p">
							<div class="main-signin-header">
								<h2>Forgot Password!</h2>
								<h4>Please Enter Your Email</h4>
								<form action="https://laravel.spruko.com/dashfox/rtl/page-profile">
									<div class="form-group">
										<label>Email</label> <input class="form-control" placeholder="Enter your email" type="text">
									</div>
									<button class="btn btn-main-primary btn-block">Send</button>
								</form>
							</div>
							<div class="main-signup-footer mg-t-10">
								<p>Forget it, <a href="signin.html"> Send me back</a> to the sign in screen.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Main-signin-wrapper -->
	
	
			</div>
        <!-- JQuery min js -->
<script src="{{ asset('back') }}/assets/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap4 js-->
<script src="{{ asset('back') }}/assets/plugins/bootstrap/popper.min.js"></script>
<script src="{{ asset('back') }}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- Ionicons js -->
<script src="{{ asset('back') }}/assets/plugins/ionicons/ionicons.js"></script>

<!-- Moment js -->
<script src="{{ asset('back') }}/assets/plugins/moment/moment.js"></script>

<!-- eva-icons js -->
<script src="{{ asset('back') }}/assets/plugins/eva-icons/eva-icons.min.js"></script>
  
<!-- Rating js-->
<script src="{{ asset('back') }}/assets/plugins/rating/jquery.rating-stars.js"></script>
<script src="{{ asset('back') }}/assets/plugins/rating/jquery.barrating.js"></script>

 
 

<!-- custom js -->
<script src="{{ asset('back') }}/assets/js/custom.js"></script>
        
	</body>

<!-- Mirrored from laravel.spruko.com/dashfox/ltr/signin by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Mar 2021 20:07:50 GMT -->
</html>