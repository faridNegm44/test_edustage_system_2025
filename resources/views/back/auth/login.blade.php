
<!DOCTYPE html>
<html lang="en" dir="rtl">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="dashboard, admin, bootstrap admin template, codeigniter, php, php framework, codeigniter 4, php mvc, php codeigniter, best php framework, codeigniter admin, codeigniter dashboard, admin panel template, bootstrap 4 admin template, bootstrap dashboard template"/>

		<!-- Title -->
		<title> أكاديمية إديوستيدج | تسجيل الدخول </title>

		<!-- Favicon -->
		<link rel="icon" href="{{ asset('back/images/settings/logo.png') }}" type="image/x-icon"/>

		<!-- Bootstrap css-->
		<link href="{{ asset('back') }}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

		<!-- Icons css -->
		<link href="{{ asset('back') }}/assets/css-rtl/icons.css" rel="stylesheet">

        <!-- P-scroll bar css remove in final -->
		<link href="{{ asset('back') }}/assets/plugins/perfect-scrollbar/p-scrollbar.css" rel="stylesheet" />

		<!-- Style css -->
		<link href="{{ asset('back') }}/assets/css-rtl/style.css" rel="stylesheet">

		<!-- Dark-mode css -->
		<link href="{{ asset('back') }}/assets/css-rtl/style-dark.css" rel="stylesheet">

		{{-- alertify --}}
		<link href="{{ asset('back/assets/css-rtl/alertify.rtl.min.css') }}" type="text/css" rel="stylesheet"/>
		<link href="{{ asset('back/assets/css-rtl/default.rtl.min.css') }}" type="text/css" rel="stylesheet"/>

		<!---Skinmodes css-->
		<link href="{{ asset('back') }}/assets/css-rtl/skin-modes.css" rel="stylesheet" />

		<!---Switcher css-->
		<link href="{{ asset('back') }}/assets/switcher/css/switcher-rtl.css" rel="stylesheet">
		<link href="{{ asset('back') }}/assets/switcher/demo.css" rel="stylesheet">

		<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Cairo:slnt,wght@11,200..1000&family=Changa:wght@200..800&display=swap" rel="stylesheet">

		<style>
			@font-face {
				font-family: "4_F4";
				src: url("{{ asset('back/fonts/4_F4.ttf') }}");
			}
			body{
				/* font-family: Arial, Helvetica, sans-serif, serif; */
				/* font-family: "4_F4", serif; */
				font-family: Almarai;
				
			}
			.ajs-error{
				background: #c40707 !important;
				width: 400px !important;
			}

		</style>
    </head>
	<body class="main-body">
			
               
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{ asset('back') }}/assets/img/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

        
		<!-- Page -->
		<div class="error-page1 bg-light">
			<div class="page">

				<div class="container-fluid">
					<div class="row no-gutter">						
						
						<div class="col-md-6 col-lg-6 col-xl-5 bg-gray">
							<div class="login d-flex align-items-center py-2">
								<!-- Demo content-->
								<div class="container p-0">
									<div class="row">
										<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
											<div class="card-sigin">
												<div class="" style="margin-bottom: 2rem !important; text-align: center;">
													<img src="{{ asset('back/images/settings/'.GeneralSettingsInfo()->fav_icon) }}" class="sign-favicon ht-120 pd-10" alt="{{ GeneralSettingsInfo()->name }}" style="width: 170px;height: 160px;">

													<h1 class="main-logo1 mr-1 mr-0 my-auto" style="font-size: 25px !important;text-decoration: underline;">{{ GeneralSettingsInfo()->name }}</h1>
												</div>

												<div class="card-sigin">
													<div class="main-signup-header">
														<h2 style="font-size: 23px;">مرحباً بك مرة أخرى!</h2>
														<h5 class="font-weight-semibold mb-4" style="font-size: 17px;">يرجى تسجيل الدخول للمتابعة.</h5>
														<form action="{{ url('login_post') }}" method="POST">
															@csrf

															<div class="form-group">
																<label for="email">البريد الإلكتروني</label> 
																<input class="form-control" placeholder="البريد الإلكتروني" type="email" name="email" id="email" value="{{ old('email') }}">
															</div>
															
															<div class="form-group">
																<label for="password">الرقم السري</label> 
																<input class="form-control" placeholder="الرقم السري" type="password" name="password" id="password">
															</div>
															
															{{-- <div class="form-group">
																<label>حالة المستخدم</label> 
																<select class="form-control" placeholder="حالة الشخص" name="" id="">
																	<option value="1">سوبر أدمن</option>
																	<option value="2">فريق العمل</option>
																	<option value="3">مدرس</option>
																	<option value="4">ولي أمر</option>
																	<option value="5">طالب</option>
																</select>
															</div> --}}
															
															<br>
															<div class="form-group">
																<button class="btn btn-lg btn-main-primary btn-block">
																	تسجيل الدخول
																	<i class="fas fa-angle-left" style="font-size: 22px;position: relative;top: 3px;right: 8px;color: #dfcb31;"></i>
																</button>
															</div>

														</form>
														{{-- <div class="main-signin-footer mt-5">
															<p><a href="#">نسيت كلمة المرور ؟</a></p>
														</div> --}}
													</div>
												</div>
											</div>
										</div>
									</div>
								</div><!-- End -->
							</div>
						</div>
						
						<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent" style="background: #fff !important;">
							<div class="row wd-100p mx-auto text-center">
								<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
									<img src="{{ asset('back/images/settings/login6.jpg') }}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
								</div>
							</div>
						</div>
						
					</div>
				</div>

			</div>
		</div>
		<!-- End Page -->

	
        		<!-- JQuery min js -->
		<script src="{{ asset('back') }}/assets/plugins/jquery/jquery.min.js"></script>

		<!-- Bootstrap js -->
        <script src="{{ asset('back') }}/assets/plugins/bootstrap/js/popper.min.js"></script>
        <script src="{{ asset('back') }}/assets/plugins/bootstrap/js/bootstrap-rtl.js"></script>

		<!-- Ionicons js -->
		<script src="{{ asset('back') }}/assets/plugins/ionicons/ionicons.js"></script>

		<!-- P-scroll js Remove in final -->
		<script src="{{ asset('back') }}/assets/plugins/perfect-scrollbar/perfect-scrollbar.min-rtl.js"></script>
		<script src="{{ asset('back') }}/assets/plugins/perfect-scrollbar/p-scroll-rtl.js"></script>

		<!-- eva-icons js -->
		<script src="{{ asset('back') }}/assets/js/eva-icons.min.js"></script>

		<!-- Rating js-->
		<script src="{{ asset('back') }}/assets/plugins/rating/jquery.rating-stars.js"></script>
		<script src="{{ asset('back') }}/assets/plugins/rating/jquery.barrating.js"></script>

		<!-- alertify -->
		<script src="{{ asset('back/assets/js/alertify.min.js') }}"></script>

		<!-- custom js -->
		<script src="{{ asset('back') }}/assets/js/custom.js"></script>

		<!-- Switcher js -->
		<script src="{{ asset('back') }}/assets/switcher/js/switcher-rtl.js"></script>

		<script>    
			// check if user not register login
			if(@json(session()->has('error_auth'))){
				alertify.set('notifier','position', 'top-center');
				alertify.set('notifier','delay', 5);
				alertify.error(`<div class="text-center" style="color: #fff;font-weight: bold;">${@json(session()->get('error_auth'))}</div>`);
			}
	
			// check if user email or password error
			if(@json(session()->has('error_email_or_password'))){
				alertify.set('notifier','position', 'top-center');
				alertify.set('notifier','delay', 5);
				alertify.error(`<div class="text-center" style="color: #fff;font-weight: bold;">${@json(session()->get('error_email_or_password'))}</div>`);
			}
			@json(session()->forget('error_email_or_password'));
	
			// check if user not register email or password
			var countErrors = @json(count($errors) > 0);
			var errorMessages = @json($errors->all());
	
			if (countErrors) {
				$.each(errorMessages, function(index, message) {
					alertify.set('notifier','position', 'top-center');
					alertify.set('notifier','delay', 5);
					alertify.error(`<div class="text-center" style="color: #fff;font-weight: bold;">${message}</div>`);
				});
			}
		</script>

    </body>

<!-- Mirrored from codeigniter.spruko.com/valex/rtl/public/pages/signin by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 05 Jan 2022 09:50:18 GMT -->
</html>