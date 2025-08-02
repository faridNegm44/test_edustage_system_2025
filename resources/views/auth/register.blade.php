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
    <title> صفحه: تسجيل ولي أمر </title>
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
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700&family=Tajawal:wght@200;300;500&display=swap" rel="stylesheet">


		@yield('header')

		<style>
			body{
				font-family: cairo;
			}
			.main-card-signin{
				max-width: 80%;
				min-width: 80%;
			}
			.required_icon{
				float: left;
				color: red;
				font-size: 6px;
				margin-top: 8px;
			}
			.page-signin-style:before{
				background: rgba(109, 110, 243, .92);
			}
			.video_icon{
				padding: 6px 8px 4px;
                background: #ff6328;
                color: #fff;
                border-radius: 50%;
			}
			.video_icon:hover, .roles:hover{
				cursor: pointer;
			}
            .error{
                color: red;
            }
		</style>
</head>

    <body class="main-body light-theme">

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalLabel" aria-hidden="true" style="z-index: 1000000;">
			<div class="modal-dialog modal-xl" role="document">
			  <div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="exampleModalLabel">فديو توضيحي لكيفية التسجيل فى منطقة أعضاء أكاديمية إديوستيدج</h5>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="modal-body">
					<iframe width="100%" height="400px" src="https://www.youtube.com/embed/c-JlI1l4klU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			  </div>
			</div>
		  </div>

		<div id="global-loader">
			<img src="{{ url('back') }}/assets/img/loader-2.svg" class="loader-img" alt="Loader">
		</div>

		
        <div class="my-auto page page-h">

            		
		
		<!-- main-signin-wrapper -->
		<div class="my-auto page page-h">
			<div class="main-signin-wrapper error-wrapper">
				<div class="main-card-signin d-md-flex wd-100p col-xs-12">
					<div class="row">
				<div class="col-lg-4 page-signin-style p-5 text-white d-none d-sm-none d-md-none d-lg-block d-xl-block">
					<div class="my-auto authentication-pages">
						<div style="margin-top: -10px;">
							<img src="{{ url('back') }}/images/settings/logo.png" class=" m-0 mb-4" alt="logo">
							<h5 class="mb-4" style="text-decoration: underline;">المعلومات التي يتم تسجيلها هنا هي بيانات أولياء الأمور</h5>
							<ul >
								<li style="padding: 5px;">جميع الحقول <strong>مطلوبه</strong></li> <hr />
								<li style="padding: 5px;">يرجي إدخال <strong>بريد إالكتروني</strong> صحيح</li> <hr />
								<li style="padding: 5px;">يرجي إدخال الاسم <strong>الأول والثاني والثالث</strong> بطريقه صحيحه</li> <hr />
								<li style="padding: 5px;">عند إدخال هاتف واتساب أو موبايل أخر للتواصل يجب كتابه <strong>مفتاح الدوله</strong></li> <hr />
								<li style="padding: 5px;">عند ادخال ارقام التليفون يجب ان يكونوا <strong>مختلفين</strong></li> <hr />
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-8 col-md-12 p-5 wd-md-50p">
					<div class="main-signin-header">
							<h2>مرحبًا</h2>
							<a href="{{ url('dashboard') }}" class="float-left video_icon" style="color: #000;background: lightblue;margin: 0px 5px;padding: 6px 10px 4px;">
								<i class="fa fa-long-arrow-alt-left"></i>
						   </a>

							<span class="float-left video_icon" data-effect="effect-flip-vertical" data-toggle="modal" data-target="#modal">
							     <i class="fa fa-video"></i>
							</span>
						<h4>هذة البيانات خاصة <bold style="color: rgb(238 69 4);font-weight: bold;text-decoration: underline;">( بولي الأمر فقط )</bold> وليست للطلبة</h4>
						<br />
						<form action="{{ route('register') }}" method="POST">
                            @csrf
							<div class="row">
								<div class="form-group col-md-6">
									<label>الاسم الأول</label>
									<i class="fa fa-star required_icon"></i>
									<input class="form-control" name="TheName1" placeholder="الاسم الأول من ولي الأمر" type="text" value="{{ old('TheName1') }}">
                                    @if($errors->has('TheName1'))
                                        <div class="error">{{ $errors->first('TheName1') }}</div>
                                    @endif
								</div>
								
								<div class="form-group col-md-6">
									<label>الاسم الثاني</label>
									<i class="fa fa-star required_icon"></i>
									<input class="form-control" name="TheName2" placeholder="الاسم الثاني من ولي الأمر" type="text" value="{{ old('TheName2') }}">
                                    @if($errors->has('TheName2'))
                                        <div class="error">{{ $errors->first('TheName2') }}</div>
                                    @endif
								</div>
								
								<div class="form-group col-md-6">
									<label>الاسم الثالث</label>
									<i class="fa fa-star required_icon"></i>
									<input class="form-control" name="TheName3" placeholder="الاسم الثالث من ولي الأمر" type="text" value="{{ old('TheName3') }}">
                                    @if($errors->has('TheName3'))
                                        <div class="error">{{ $errors->first('TheName3') }}</div>
                                    @endif
								</div>
																
								<div class="form-group col-md-6">
									<label>البريد الإلكتروني</label>
									<input class="form-control" name="TheEmail" placeholder="البريد الإلكتروني لولي الأمر" type="text" value="{{ old('TheEmail') }}">
                                    @if($errors->has('TheEmail'))
                                        <div class="error">{{ $errors->first('TheEmail') }}</div>
                                    @endif
								</div>
								
								<div class="form-group col-md-6">
									<label>الرقم السري</label> 
									<i class="fa fa-star required_icon"></i>
									<input class="form-control" name="ThePass" placeholder="الرقم السري" type="password" value="">
                                    @if($errors->has('ThePass'))
                                        <div class="error">{{ $errors->first('ThePass') }}</div>
                                    @endif
								</div>

								<div class="form-group col-md-6">
									<label>تأكيد الرقم السري</label> 
									<i class="fa fa-star required_icon"></i>
									<input class="form-control" name="confirm_password" placeholder="تأكيد الرقم السري" type="password" value="">
                                    @if($errors->has('confirm_password'))
                                        <div class="error">{{ $errors->first('confirm_password') }}</div>
                                    @endif
								</div>

								<div class="form-group col-md-6">
									<label>الجنسية</label>
									<i class="fa fa-star required_icon"></i>
									<select class="form-control select2_select2" name="NatID" style="width: 100%;">
										@foreach (\DB::table('tbl_nat')->get() as $item)
										<option value="{{ $item->ID }}" @if ($item->ID == 1) selected @else '' @endif>
											{{ $item->TheName }}
										</option>
										@endforeach
									</select>
                                    @if($errors->has('NatID'))
                                        <div class="error">{{ $errors->first('NatID') }}</div>
                                    @endif
								</div>
	
								<div class="form-group col-md-6">
									<label>مكان الإقامة</label>
									<i class="fa fa-star required_icon"></i>
									<select class="form-control select2_select2" name="CityID" style="width: 100%;">
										@foreach (\DB::table('tbl_cities')->get() as $item)
										<option value="{{ $item->ID }}">
											دوله ( {{ $item->TheCountry }} ) --  مدينه ( {{ $item->TheCity }} )
										</option>
										@endforeach
									</select>
                                    @if($errors->has('CityID'))
                                        <div class="error">{{ $errors->first('CityID') }}</div>
                                    @endif
								</div>

								<div class="form-group col-md-6">
									<label>رقم واتس ولي الأمر</label> 
									<i class="fa fa-star required_icon"></i>
									<input class="form-control" name="ThePhone1" placeholder="لاتنس إضافه مفتاح الدوله خارج مصر" type="number" value="{{ old('ThePhone1') }}">
                                    @if($errors->has('ThePhone1'))
                                        <div class="error">{{ $errors->first('ThePhone1') }}</div>
                                    @endif
								</div>

								<div class="form-group col-md-6">
									<label>رقم موبايل آخر لولي الأمر</label> 
									<i class="fa fa-star required_icon"></i>
									<input class="form-control" name="ThePhone2" placeholder="لاتنس إضافه مفتاح الدوله خارج مصر" type="number" value="{{ old('ThePhone2') }}">
                                    @if($errors->has('ThePhone2'))
                                        <div class="error">{{ $errors->first('ThePhone2') }}</div>
                                    @endif
								</div>

								<div class="form-group col-md-12">
									<input class="" name="roles" type="checkbox" style="margin-left: 10px;width: 20px;height: 20px;position: relative;top: 5px;">
									<a href="https://edustage.net/_site/policy/" target="_blank" style="text-decoration: underline;color: red;font-weight: bold;">سياسة EduStage Academy مع السادة المشتركين في خدمات الأكاديمية</a>
                                    @if($errors->has('roles'))
                                        <div class="error" style="color: #000;">{{ $errors->first('roles') }}</div>
                                    @endif
								</div>
							</div>

							<button class="btn btn-main-primary btn-block" type="submit" style="background: rgb(2 4 81);">تسجيل</button>
						</form>
					</div>
				</div>
			</div>
			</div>
			</div>
		</div>
		<!-- /main-signin-wrapper -->


        </div>

<script src="{{ url('back') }}/assets/plugins/jquery/jquery.min.js"></script>
<script src="{{ url('back') }}/assets/plugins/bootstrap/popper.min.js"></script>
<script src="{{ url('back') }}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ url('back') }}/assets/plugins/ionicons/ionicons.js"></script>
<script src="{{ url('back') }}/assets/plugins/moment/moment.js"></script>
<script src="{{ url('back') }}/assets/plugins/eva-icons/eva-icons.min.js"></script>
<script src="{{ url('back') }}/assets/plugins/rating/jquery.rating-stars.js"></script>
<script src="{{ url('back') }}/assets/plugins/rating/jquery.barrating.js"></script>

<script src="{{ url('back') }}/assets/js/custom.js"></script>
    


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
        $('.select2_select2').select2();
    });
</script>
<script>

    // $("form").submit(function(e){
    // e.preventDefault();
    //     var url = $(this).attr('action');

    //     $.ajax({
    //         type: "post",
    //         headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
    //         url: url,
    //         data: $('form').serialize(),
    //         success: function (res) {
    //             $('input').val('');
    //             window.location.href = "{{ url('dashboard/login') }}"
    //         },
    //         error: function (res) {
    //             if(res.responseJSON.errors.TheName1){
    //                 $("form .errors-TheName1").css('display' , 'block').text(res.responseJSON.errors.TheName1);
    //             }else{
    //                 $("form .errors-TheName1").text('');
    //             }
    //             if(res.responseJSON.errors.TheName2){
    //                 $("form .errors-TheName2").css('display' , 'block').text(res.responseJSON.errors.TheName2);
    //             }else{
    //                 $("form .errors-TheName2").text('');
    //             }
    //             if(res.responseJSON.errors.TheName3){
    //                 $("form .errors-TheName3").css('display' , 'block').text(res.responseJSON.errors.TheName3);
    //             }else{
    //                 $("form .errors-TheName3").text('');
    //             }
    //             if(res.responseJSON.errors.TheEmail){
    //                 $("form .errors-TheEmail").css('display' , 'block').text(res.responseJSON.errors.TheEmail);
    //             }else{
    //                 $("form .errors-TheEmail").text('');
    //             }
    //             if(res.responseJSON.errors.ThePass){
    //                 $("form .errors-ThePass").css('display' , 'block').text(res.responseJSON.errors.ThePass);
    //             }else{
    //                 $("form .errors-ThePass").text('');
    //             }
    //             if(res.responseJSON.errors.confirm_password){
    //                 $("form .errors-confirm_password").css('display' , 'block').text(res.responseJSON.errors.confirm_password);
    //             }else{
    //                 $("form .errors-confirm_password").text('');
    //             }
    //             if(res.responseJSON.errors.ThePhone1){
    //                 $("form .errors-ThePhone1").css('display' , 'block').text(res.responseJSON.errors.ThePhone1);
    //             }else{
    //                 $("form .errors-ThePhone1").text('');
    //             }
    //             if(res.responseJSON.errors.ThePhone2){
    //                 $("form .errors-ThePhone2").css('display' , 'block').text(res.responseJSON.errors.ThePhone2);
    //             }else{
    //                 $("form .errors-ThePhone2").text('');
    //             }
    //             if(res.responseJSON.errors.NatID){
    //                 $("form .errors-NatID").css('display' , 'block').text(res.responseJSON.errors.NatID);
    //             }else{
    //                 $("form .errors-NatID").text('');
    //             }
    //             if(res.responseJSON.errors.CityID){
    //                 $("form .errors-CityID").css('display' , 'block').text(res.responseJSON.errors.CityID);
    //             }else{
    //                 $("form .errors-CityID").text('');
    //             }
    //             if(res.responseJSON.errors.roles){
    //                 $("form .errors-roles").css('display' , 'block').text(res.responseJSON.errors.roles);
    //             }else{
    //                 $("form .errors-roles").text('');
    //             }
    //         }
    //     });
    // });

    </script>

	<script>
		$(document).ready(function(){
			$("#modal").modal('show');
		});
	</script>
</body>

</html>