<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<html lang="ar" dir="rtl">
<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Dashfox - Laravel Admin & Dashboard Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords" content="admin template, admin dashboard, bootstrap dashboard template, bootstrap 4 admin template, laravel, php framework, php laravel, laravel framework, php mvc, laravel admin panel, laravel admin panel, laravel template, laravel bootstrap, blade laravel, best php framework"/>
    <title>
		صفحه : التحقق من البريد الإلكتروني	
	</title>
    <link rel="icon" href="{{ url('back') }}/assets/img/brand/favicon.png" type="image/x-icon"/>
		<link href="{{ url('back') }}/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />
		<link href="{{ url('back') }}/assets/plugins/icons/icons.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/plugins/sidebar/sidebar.css" rel="stylesheet">
		<link rel="stylesheet" href="{{ url('back') }}/assets/css-rtl/sidemenu.css">
		<link href="{{ url('back') }}/assets/css-rtl/style.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/css-rtl/style-dark.css" rel="stylesheet">
		<link id="theme" href="{{ url('back') }}/assets/css-rtl/colors/color.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />
		<link href="{{ url('back') }}/assets/plugins/jqvmap/jqvmap.min.css" rel="stylesheet">
        <link href="{{ url('back') }}/assets/plugins/jqvmap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
		<link href="{{ url('back') }}/assets/css-rtl/skin-modes.css" rel="stylesheet" />
		<link href="{{ url('back') }}/assets/css-rtl/animate.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/switcher/css/switcher-rtl.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/switcher/demo.css" rel="stylesheet">
		<link href="{{ url('back') }}/assets/plugins/notify/css/notifIt.css" rel="stylesheet"/>

		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=Changa:500|El+Messiri|Harmattan|Mada:600|Tajawal:700" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
		<link rel="preconnect" href="https://fonts.gstatic.com">
	
		<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700&family=Tajawal:wght@200;300;500&display=swap" rel="stylesheet">

		<style>
          *{
			  font-family: cairo;
		  }
</style>

		@yield('header')
</head>

    <body class="main-body light-theme">

		<!-- Loader -->
		<div id="global-loader">
			<img src="{{ url('back') }}/assets/img/loader-2.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- main-signin-wrapper -->

        <div class="my-auto page page-h">

            		
		
		<!-- main-signin-wrapper -->
		<div class="my-auto page page-h">
			<div class="main-signin-wrapper error-wrapper">
				<div class="main-card-signin d-md-flex wd-100p">
				<div class="col-sm-12 text-center" style="padding: 20px;">
					<div class="main-signin-header">
						<h3 style="margin: 20px auto;">تم إرسال رابط تحقق جديد إلى عنوان بريدك الإلكتروني</h3>

                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline" style="text-decoration: underline;font-size: 16px;">
                                 انقر هنا لإعاده إرسال رابط تحقق لبريدك الإلكتروني من جديد    
                            </button>.
                        </form>

					</div>
					<div class="main-signin-footer mt-3 mg-t-5">
						<p>
							<a href="{{ url('/dashboard') }}" style="margin: 0px 0px 0px 15px;">الصفخة الرئيسيه</a>
							<a href="{{ url('/dashboard/logout') }}" style="color: red;">تسجيل خروج</a>
						</p>
					</div>
				</div>
			</div>
			</div>
		</div>
		<!-- /main-signin-wrapper -->


        </div>

		<!-- /main-signin-wrapper -->

        <!-- JQuery min js -->
<script src="{{ url('back') }}/assets/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap4 js-->
<script src="{{ url('back') }}/assets/plugins/bootstrap/popper.min.js"></script>
<script src="{{ url('back') }}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- Ionicons js -->
<script src="{{ url('back') }}/assets/plugins/ionicons/ionicons.js"></script>

<!-- Moment js -->
<script src="{{ url('back') }}/assets/plugins/moment/moment.js"></script>

<!-- eva-icons js -->
<script src="{{ url('back') }}/assets/plugins/eva-icons/eva-icons.min.js"></script>
  
<!-- Rating js-->
<script src="{{ url('back') }}/assets/plugins/rating/jquery.rating-stars.js"></script>
<script src="{{ url('back') }}/assets/plugins/rating/jquery.barrating.js"></script>

 
 

<!-- custom js -->
<script src="{{ url('back') }}/assets/js/custom.js"></script>
        
	</body>

<!-- Mirrored from laravel.spruko.com/dashfox/ltr/signin by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Mar 2021 20:07:50 GMT -->
</html>