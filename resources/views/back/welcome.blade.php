@extends('back.layouts.app')

@section('title')
    الرئيسية
@endsection

@section('header')
	<style>
		#first_section .card-body{
			padding: 11px !important;
			height: 70px !important;
		}
		#second_section .card-body{
			padding: 5px !important;
		}
		td, th{
			font-size: 10px;
			text-align: center;
			padding: 2px !important;
		}
		.ajs-success, .ajs-error{
			min-width: 450px !important;
		}
		.dashboard-card {
			transition: all 0.3s ease-in-out;
			cursor: pointer;
			border: 2px solid transparent;
		}

		.dashboard-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
			border-color: #0d6efd; /* تغيير لون الإطار عند الهوفر */
		}

		.dashboard-card:hover i {
			transform: scale(1.2) translateY(-3px);
		}
		#first_section .card:hover, #second_section .card:hover {
			transform: scale(1.1) translateY(-6px);
			box-shadow: 10px 8px 16px rgba(0, 0, 0, 0.15);
			transition: transform 0.5s ease;
		}
		.dashboard-card i {
			transition: transform 0.3s ease;
		}

		.dashboard-card:hover span {
			font-weight: bold;
			letter-spacing: 0.5px;
		}

		.breadcrumb-header {
			margin-top: 2px !important;
			margin-bottom: 2px !important;
		}
	</style>
@endsection

@section('footer')
	@if (session()->has('success_login'))
		<script>
			$(document).ready(function () {
				alertify.set('notifier','position', 'top-center');
				alertify.set('notifier','delay', 4);
				alertify.success("مرحبا ( {{ auth()->user()->name }} )");
			});
		</script>
	@endif

	@if (session()->has('notAuth'))
		<script>
			$(document).ready(function () {
				alertify.dialog('alert')
						.set({transition:'slide',message: `
							<div style="text-align: center;">
								<p style="color: #e67e22; font-size: 18px; margin-bottom: 10px;">
									صلاحية غير متوفرة 🔐⚠️
								</p>
								<p>{{ session()->get('notAuth') }}</p>
							</div>
						`, 'basic': true})
						.show();  

			});
		</script>
	@endif
@endsection

@section('content')

	@php
		$user = null;
		
		if(auth()->guard('web')->check()){
			$user = auth()->guard('web')->user();

		}elseif(auth()->guard('student')->check()){
			$user = auth()->guard('student')->user();
		}
	@endphp

<div class="container-fluid">
	<!-- breadcrumb -->
	<div class="breadcrumb-header d-flex justify-content-between align-items-center flex-wrap" >

		{{-- رسالة الترحيب والمسمى الوظيفي --}}
		<div class="left-content" >
			<div class="d-flex align-items-center flex-wrap">
				{{-- اسم المستخدم والحالة --}}
				<h5 class="main-content-title tx-15 mb-1 me-3">
					مرحباً - {{ auth()->user()->name }} 
					<span class="bg bg-primary-transparent ms-2">
						- 
						@switch(auth()->user()->user_status)
							@case(1) سوبر أدمن @break
							@case(2) موظف @break
							@case(3) ولي أمر @break
							@case(4) مدرس @break
							@case(5) طالب @break
						@endswitch
						
					</span>
				</h5>

				@if (auth()->user()->user_status != 3 && $selected_academic_years->selected_academic_year !== null)
					@php
						$yearId = $selected_academic_years->selected_academic_year;
						$yearName = $yearId === 0 ? 'الكل' : optional(\DB::table('academic_years')->find($yearId))->name;
					@endphp
					<div class="ms-auto mt-2 mt-lg-0">
						<span class="fw-bold text-danger">
							🎓  السنة الأكاديمية المختارة: <span class="text-primary">{{ $yearName }}</span>
						</span>
					</div>
				@endif
			</div>
		</div>


		{{-- قائمة اختيار السنة الأكاديمية --}}
		<div class="main-dashboard-header-right">
			<div class="d-flex align-items-center">
				<label class="tx-13 me-2 mb-0" style="margin-left: 10px;">سنوات الأكاديمية</label>
				<select class="form-control" name="getDataByAcademicYear" id="getDataByAcademicYear" style="width: 150px;">
					<option disabled selected>اختر سنة</option>
					<option value="0">الكل</option>
					@if (auth()->user()->user_status != 3)
						@foreach ($academic_years as $academic_year)
							<option value="{{ $academic_year->id }}">{{ $academic_year->name }}</option>
						@endforeach
					@endif
				</select>
			</div>
		</div>
	</div>
	<hr style="border: 1px solid #cfdbe9 !important;margin-bottom: 20px !important;margin-top: 5px !important;">


	{{---------------------------- start first section ------------------------------}}
	<div class="row g-3 justify-content-center" id="first_section">

		<div class="col-md-2 col-12" data-placement="bottom" data-toggle="tooltip" title="المجموعات التعليمية">
			<div class="card text-center dashboard-card border">
			<div class="card-body">
				<a href="{{ url('groups') }}" target="_blank" class="text-decoration-none">
				<i class="fas fa-layer-group fa-2x mb-1 d-block"></i>
				<span class="fw-bold tx-10">المجموعات التعليمية</span>
				</a>
			</div>
			</div>
		</div>

		<div class="col-md-2 col-12" data-placement="bottom" data-toggle="tooltip" title="المدرسون">
			<div class="card text-center dashboard-card border">
			<div class="card-body">
				<a href="{{ url('teachers') }}" target="_blank" class="text-decoration-none">
				<i class="fas fa-chalkboard-teacher fa-2x mb-1 d-block"></i>
				<span class="fw-bold tx-10">المدرسون</span>
				</a>
			</div>
			</div>
		</div>

		<div class="col-md-2 col-12" data-placement="bottom" data-toggle="tooltip" title="أولياء الأمور">
			<div class="card text-center dashboard-card border">
			<div class="card-body">
				<a href="{{ url('guardians') }}" target="_blank" class="text-decoration-none">
				<i class="fas fa-user-shield fa-2x mb-1 d-block"></i>
				<span class="fw-bold tx-10">أولياء الأمور</span>
				</a>
			</div>
			</div>
		</div>

		<div class="col-md-2 col-12" data-placement="bottom" data-toggle="tooltip" title="الطلاب">
			<div class="card text-center dashboard-card border">
			<div class="card-body">
				<a href="{{ url('students') }}" target="_blank" class="text-decoration-none">
				<i class="fas fa-user-graduate fa-2x mb-1 d-block"></i>
				<span class="fw-bold tx-10">الطلاب</span>
				</a>
			</div>
			</div>
		</div>

		<div class="col-md-2 col-12" data-placement="bottom" data-toggle="tooltip" title="جدول الحصص">
			<div class="card text-center dashboard-card border">
			<div class="card-body">
				<a href="{{ url('schedules') }}" target="_blank" class="text-decoration-none">
				<i class="fas fa-calendar-alt fa-2x mb-1 d-block"></i>
				<span class="fw-bold tx-10">جدول الحصص</span>
				</a>
			</div>
			</div>
		</div>

		<div class="col-md-2 col-12" data-placement="bottom" data-toggle="tooltip" title="متحصلات من أولياء الأمور">
			<div class="card text-center dashboard-card border">
			<div class="card-body">
				<a href="{{ url('guardians/receipts') }}" target="_blank" class="text-decoration-none">
				<i class="fas fa-hand-holding-usd fa-2x mb-1 d-block"></i>
				<span class="fw-bold tx-10">متحصلات أولياء الأمور</span>
				</a>
			</div>
			</div>
		</div>

		</div>

	<hr style="border: 1px solid #cfdbe9 !important;margin-bottom: 20px !important;margin-top: 5px !important;">
	{{------------------------------ end first section ------------------------------}}
	
	







	{{-- ----------------------------start second section ------------------------------}}
	<div class="row row-sm" id="second_section">

		<div class="col-lg-3 col-md-3 col-6">
			<a href="#" class="text-white">
				<div class="card bg-info-gradient text-white">
					<div class="card-body">
						<div class="row">
							<div class="col-2 text-center" style="padding: 0px 15px;">
								<i class="fas fa-user-shield tx-30 mt-2"></i>
							</div>
							<div class="col-9 text-center">
								<span style="font-size: 11px;font-weight: bold;">كشف حساب ولي أمر</span>
								<h4 class="mb-0">100</h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>

		<div class="col-lg-3 col-md-3 col-6">
			<a href="#" class="text-white">
				<div class="card bg text-white" style="background-image: linear-gradient(to right, #cc6600c2 0, #86c722b5 100%) !important;">
					<div class="card-body">
						<div class="row">
							<div class="col-2 text-center" style="padding: 0px 15px;">
								<i class="fas fa-money-check-alt tx-30 mt-2"></i>
							</div>
							<div class="col-9 text-center">
								<span style="font-size: 11px;font-weight: bold;">كشف مدفوعات ولي أمر</span>
								<h4 class="mb-0">900</h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>

		<div class="col-lg-3 col-md-3 col-6">
			<a href="#" class="text-white">
				<div class="card bg-success-gradient text-white">
					<div class="card-body">
						<div class="row">
							<div class="col-2 text-center" style="padding: 0px 15px;">
								<i class="fas fa-users tx-30 mt-2"></i>
							</div>
							<div class="col-9 text-center">
								<span style="font-size: 11px;font-weight: bold;">كشف حسابات المدرسين العام</span>
								<h4 class="mb-0">200</h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>

		<div class="col-lg-3 col-md-3 col-6">
			<a href="#" class="text-white">
				<div class="card bg-primary-gradient text-white">
					<div class="card-body">
						<div class="row">
							<div class="col-2 text-center" style="padding: 0px 15px;">
								<i class="fas fa-percentage tx-30 mt-2"></i>
							</div>
							<div class="col-9 text-center">
								<span style="font-size: 11px;font-weight: bold;">كشف مدرس تفصيلي - نسبة</span>
								<h4 class="mb-0">300</h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>

		<div class="col-lg-3 col-md-3 col-6">
			<a href="#" class="text-white">
				<div class="card bg-warning-gradient text-white">
					<div class="card-body">
						<div class="row">
							<div class="col-2 text-center" style="padding: 0px 15px;">
								<i class="fas fa-dollar-sign tx-30 mt-2"></i>
							</div>
							<div class="col-9 text-center">
								<span style="font-size: 11px;font-weight: bold;">كشف مدرس تفصيلي - قيمة ثابتة</span>
								<h4 class="mb-0">400</h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>

		<div class="col-lg-3 col-md-3 col-6">
			<a href="#" class="text-white">
				<div class="card bg-secondary-gradient text-white">
					<div class="card-body">
						<div class="row">
							<div class="col-2 text-center" style="padding: 0px 15px;">
								<i class="fas fa-chalkboard-teacher tx-30 mt-2"></i>
							</div>
							<div class="col-9 text-center">
								<span style="font-size: 11px;font-weight: bold;">تقرير حصص المدرس</span>
								<h4 class="mb-0">700</h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>

		<div class="col-lg-3 col-md-3 col-6">
			<a href="#" class="text-white">
				<div class="card bg-purple-gradient text-white">
					<div class="card-body">
						<div class="row">
							<div class="col-2 text-center" style="padding: 0px 15px;">
								<i class="fas fa-clipboard-list tx-30 mt-2"></i>
							</div>
							<div class="col-9 text-center">
								<span style="font-size: 11px;font-weight: bold;">الكشف المالي العام</span>
								<h4 class="mb-0">500</h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>

		<div class="col-lg-3 col-md-3 col-6">
			<a href="#" class="text-white">
				<div class="card bg-danger-gradient text-white">
					<div class="card-body">
						<div class="row">
							<div class="col-2 text-center" style="padding: 0px 15px;">
								<i class="fas fa-exchange-alt tx-30 mt-2"></i>
							</div>
							<div class="col-9 text-center">
								<span style="font-size: 11px;font-weight: bold;">الحركة المالية</span>
								<h4 class="mb-0">600</h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>

		<div class="col-lg-3 col-md-3 col-6">
			<a href="#" class="text-white">
				<div class="card bg text-white" style="background-image: linear-gradient(to right, #242d42 0, #515f7f 100%) !important;">
					<div class="card-body">
						<div class="row">
							<div class="col-2 text-center" style="padding: 0px 15px;">
								<i class="fas fa-object-group tx-30 mt-2"></i>
							</div>
							<div class="col-9 text-center">
								<span style="font-size: 11px;font-weight: bold;">تقرير حصص لجروب</span>
								<h4 class="mb-0">800</h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>

		<div class="col-lg-3 col-md-3 col-6">
			<a href="#" class="text-white">
				<div class="card bg text-white" style="background-image: linear-gradient(to left, #a674b1, #b69df5) !important;">
					<div class="card-body">
						<div class="row">
							<div class="col-2 text-center" style="padding: 0px 15px;">
								<i class="fas fa-book-open tx-30 mt-2"></i>
							</div>
							<div class="col-9 text-center">
								<span style="font-size: 11px;font-weight: bold;">كشف حصص الطلاب</span>
								<h4 class="mb-0">1000</h4>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>

	</div>
	<hr style="border: 1px solid #cfdbe9 !important;margin-bottom: 20px !important;margin-top: 5px !important;">
	{{-- ----------------------------end second section ------------------------------}}
		











	<!-- /breadcrumb -->

		<!-- row -->
	<!--	<div class="row row-sm">-->
	<!--		<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">-->
	<!--			<div class="card overflow-hidden sales-card bg-primary-gradient">-->
	<!--				<div class="pl-3 pt-3 pr-3 pb-2 pt-0">-->
	<!--					<div class="">-->
	<!--						<h6 class="mb-3 tx-12 text-white">TODAY ORDERS</h6>-->
	<!--					</div>-->
	<!--					<div class="pb-0 mt-0">-->
	<!--						<div class="d-flex">-->
	<!--							<div class="">-->
	<!--								<h4 class="tx-20 font-weight-bold mb-1 text-white">$5,74.12</h4>-->
	<!--								<p class="mb-0 tx-12 text-white op-7">Compared to last week</p>-->
	<!--							</div>-->
	<!--							<span class="float-right my-auto mr-auto">-->
	<!--								<i class="fas fa-arrow-circle-up text-white"></i>-->
	<!--								<span class="text-white op-7"> +427</span>-->
	<!--							</span>-->
	<!--						</div>-->
	<!--					</div>-->
	<!--				</div>-->
	<!--				<span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--		<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">-->
	<!--			<div class="card overflow-hidden sales-card bg-danger-gradient">-->
	<!--				<div class="pl-3 pt-3 pr-3 pb-2 pt-0">-->
	<!--					<div class="">-->
	<!--						<h6 class="mb-3 tx-12 text-white">TODAY EARNINGS</h6>-->
	<!--					</div>-->
	<!--					<div class="pb-0 mt-0">-->
	<!--						<div class="d-flex">-->
	<!--							<div class="">-->
	<!--								<h4 class="tx-20 font-weight-bold mb-1 text-white">$1,230.17</h4>-->
	<!--								<p class="mb-0 tx-12 text-white op-7">Compared to last week</p>-->
	<!--							</div>-->
	<!--							<span class="float-right my-auto mr-auto">-->
	<!--								<i class="fas fa-arrow-circle-down text-white"></i>-->
	<!--								<span class="text-white op-7"> -23.09%</span>-->
	<!--							</span>-->
	<!--						</div>-->
	<!--					</div>-->
	<!--				</div>-->
	<!--				<span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--		<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">-->
	<!--			<div class="card overflow-hidden sales-card bg-success-gradient">-->
	<!--				<div class="pl-3 pt-3 pr-3 pb-2 pt-0">-->
	<!--					<div class="">-->
	<!--						<h6 class="mb-3 tx-12 text-white">TOTAL EARNINGS</h6>-->
	<!--					</div>-->
	<!--					<div class="pb-0 mt-0">-->
	<!--						<div class="d-flex">-->
	<!--							<div class="">-->
	<!--								<h4 class="tx-20 font-weight-bold mb-1 text-white">$7,125.70</h4>-->
	<!--								<p class="mb-0 tx-12 text-white op-7">Compared to last week</p>-->
	<!--							</div>-->
	<!--							<span class="float-right my-auto mr-auto">-->
	<!--								<i class="fas fa-arrow-circle-up text-white"></i>-->
	<!--								<span class="text-white op-7"> 52.09%</span>-->
	<!--							</span>-->
	<!--						</div>-->
	<!--					</div>-->
	<!--				</div>-->
	<!--				<span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--		<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">-->
	<!--			<div class="card overflow-hidden sales-card bg-warning-gradient">-->
	<!--				<div class="pl-3 pt-3 pr-3 pb-2 pt-0">-->
	<!--					<div class="">-->
	<!--						<h6 class="mb-3 tx-12 text-white">PRODUCT SOLD</h6>-->
	<!--					</div>-->
	<!--					<div class="pb-0 mt-0">-->
	<!--						<div class="d-flex">-->
	<!--							<div class="">-->
	<!--								<h4 class="tx-20 font-weight-bold mb-1 text-white">$4,820.50</h4>-->
	<!--								<p class="mb-0 tx-12 text-white op-7">Compared to last week</p>-->
	<!--							</div>-->
	<!--							<span class="float-right my-auto mr-auto">-->
	<!--								<i class="fas fa-arrow-circle-down text-white"></i>-->
	<!--								<span class="text-white op-7"> -152.3</span>-->
	<!--							</span>-->
	<!--						</div>-->
	<!--					</div>-->
	<!--				</div>-->
	<!--				<span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--	</div>-->
		<!-- row closed -->

		<!-- row opened -->
	<!--	<div class="row row-sm">-->
	<!--		<div class="col-md-12 col-lg-12 col-xl-7">-->
	<!--			<div class="card">-->
	<!--				<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">-->
	<!--					<div class="d-flex justify-content-between">-->
	<!--						<h4 class="card-title mb-0">Order status</h4>-->
	<!--						<i class="mdi mdi-dots-horizontal text-gray"></i>-->
	<!--					</div>-->
	<!--					<p class="tx-12 text-muted mb-0">Order Status and Tracking. Track your order from ship date to arrival. To begin, enter your order number.</p>-->
	<!--				</div>-->
	<!--				<div class="card-body">-->
	<!--					<div class="total-revenue">-->
	<!--						<div>-->
	<!--						<h4>120,750</h4>-->
	<!--						<label><span class="bg-primary"></span>success</label>-->
	<!--						</div>-->
	<!--						<div>-->
	<!--						<h4>56,108</h4>-->
	<!--						<label><span class="bg-danger"></span>Pending</label>-->
	<!--						</div>-->
	<!--						<div>-->
	<!--						<h4>32,895</h4>-->
	<!--						<label><span class="bg-warning"></span>Failed</label>-->
	<!--						</div>-->
	<!--					</div>-->
	<!--					<div id="bar" class="sales-bar mt-4"></div>-->
	<!--				</div>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--		<div class="col-lg-12 col-xl-5">-->
	<!--			<div class="card card-dashboard-map-one">-->
	<!--				<label class="main-content-label">Sales Revenue by Customers in USA</label>-->
	<!--				<span class="d-block mg-b-20 text-muted tx-12">Sales Performance of all states in the United States</span>-->
	<!--				<div class="">-->
	<!--					<div class="vmap-wrapper ht-180" id="vmap2"></div>-->
	<!--				</div>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--	</div>-->
		<!-- row closed -->

		<!-- row opened -->
	<!--	<div class="row row-sm">-->
	<!--		<div class="col-xl-4 col-md-12 col-lg-12">-->
	<!--			<div class="card">-->
	<!--				<div class="card-header pb-1">-->
	<!--					<h3 class="card-title mb-2">Recent Customers</h3>-->
	<!--					<p class="tx-12 mb-0 text-muted">A customer is an individual or business that purchases the goods service has evolved to include real-time</p>-->
	<!--				</div>-->
	<!--				<div class="card-body p-0 customers mt-1">-->
	<!--					<div class="list-group list-lg-group list-group-flush">-->
	<!--						<div class="list-group-item list-group-item-action" href="#">-->
	<!--							<div class="media mt-0">-->
	<!--								<img class="avatar-lg rounded-circle ml-3 my-auto" src="{{ asset('back') }}/assets/img/faces/3.jpg" alt="Image description">-->
	<!--								<div class="media-body">-->
	<!--									<div class="d-flex align-items-center">-->
	<!--										<div class="mt-0">-->
	<!--											<h5 class="mb-1 tx-15">Samantha Melon</h5>-->
	<!--											<p class="mb-0 tx-13 text-muted">User ID: #1234 <span class="text-success ml-2">Paid</span></p>-->
	<!--										</div>-->
	<!--										<span class="mr-auto wd-45p fs-16 mt-2">-->
	<!--											<div id="spark1" class="wd-100p"></div>-->
	<!--										</span>-->
	<!--									</div>-->
	<!--								</div>-->
	<!--							</div>-->
	<!--						</div>-->
	<!--						<div class="list-group-item list-group-item-action" href="#">-->
	<!--							<div class="media mt-0">-->
	<!--								<img class="avatar-lg rounded-circle ml-3 my-auto" src="{{ asset('back') }}/assets/img/faces/11.jpg" alt="Image description">-->
	<!--								<div class="media-body">-->
	<!--									<div class="d-flex align-items-center">-->
	<!--										<div class="mt-1">-->
	<!--											<h5 class="mb-1 tx-15">Jimmy Changa</h5>-->
	<!--											<p class="mb-0 tx-13 text-muted">User ID: #1234 <span class="text-danger ml-2">Pending</span></p>-->
	<!--										</div>-->
	<!--										<span class="mr-auto wd-45p fs-16 mt-2">-->
	<!--											<div id="spark2" class="wd-100p"></div>-->
	<!--										</span>-->
	<!--									</div>-->
	<!--								</div>-->
	<!--							</div>-->
	<!--						</div>-->
	<!--						<div class="list-group-item list-group-item-action" href="#">-->
	<!--							<div class="media mt-0">-->
	<!--								<img class="avatar-lg rounded-circle ml-3 my-auto" src="{{ asset('back') }}/assets/img/faces/17.jpg" alt="Image description">-->
	<!--								<div class="media-body">-->
	<!--									<div class="d-flex align-items-center">-->
	<!--										<div class="mt-1">-->
	<!--											<h5 class="mb-1 tx-15">Gabe Lackmen</h5>-->
	<!--											<p class="mb-0 tx-13 text-muted">User ID: #1234<span class="text-danger ml-2">Pending</span></p>-->
	<!--										</div>-->
	<!--										<span class="mr-auto wd-45p fs-16 mt-2">-->
	<!--											<div id="spark3" class="wd-100p"></div>-->
	<!--										</span>-->
	<!--									</div>-->
	<!--								</div>-->
	<!--							</div>-->
	<!--						</div>-->
	<!--						<div class="list-group-item list-group-item-action" href="#">-->
	<!--							<div class="media mt-0">-->
	<!--								<img class="avatar-lg rounded-circle ml-3 my-auto" src="{{ asset('back') }}/assets/img/faces/15.jpg" alt="Image description">-->
	<!--								<div class="media-body">-->
	<!--									<div class="d-flex align-items-center">-->
	<!--										<div class="mt-1">-->
	<!--											<h5 class="mb-1 tx-15">Manuel Labor</h5>-->
	<!--											<p class="mb-0 tx-13 text-muted">User ID: #1234<span class="text-success ml-2">Paid</span></p>-->
	<!--										</div>-->
	<!--										<span class="mr-auto wd-45p fs-16 mt-2">-->
	<!--											<div id="spark4" class="wd-100p"></div>-->
	<!--										</span>-->
	<!--									</div>-->
	<!--								</div>-->
	<!--							</div>-->
	<!--						</div>-->
	<!--						<div class="list-group-item list-group-item-action br-br-7 br-bl-7" href="#">-->
	<!--							<div class="media mt-0">-->
	<!--								<img class="avatar-lg rounded-circle ml-3 my-auto" src="{{ asset('back') }}/assets/img/faces/6.jpg" alt="Image description">-->
	<!--								<div class="media-body">-->
	<!--									<div class="d-flex align-items-center">-->
	<!--										<div class="mt-1">-->
	<!--											<h5 class="mb-1 tx-15">Sharon Needles</h5>-->
	<!--											<p class="b-0 tx-13 text-muted mb-0">User ID: #1234<span class="text-success ml-2">Paid</span></p>-->
	<!--										</div>-->
	<!--										<span class="mr-auto wd-45p fs-16 mt-2">-->
	<!--											<div id="spark5" class="wd-100p"></div>-->
	<!--										</span>-->
	<!--									</div>-->
	<!--								</div>-->
	<!--							</div>-->
	<!--						</div>-->
	<!--					</div>-->
	<!--				</div>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--		<div class="col-xl-4 col-md-12 col-lg-6">-->
	<!--			<div class="card">-->
	<!--				<div class="card-header pb-1">-->
	<!--					<h3 class="card-title mb-2">Sales Activity</h3>-->
	<!--					<p class="tx-12 mb-0 text-muted">Sales activities are the tactics that salespeople use to achieve their goals and objective</p>-->
	<!--				</div>-->
	<!--				<div class="product-timeline card-body pt-2 mt-1">-->
	<!--					<ul class="timeline-1 mb-0">-->
	<!--						<li class="mt-0"> <i class="ti-pie-chart bg-primary-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Total Products</span> <a href="#" class="float-left tx-11 text-muted">3 days ago</a>-->
	<!--							<p class="mb-0 text-muted tx-12">1.3k New Products</p>-->
	<!--						</li>-->
	<!--						<li class="mt-0"> <i class="mdi mdi-cart-outline bg-danger-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Total Sales</span> <a href="#" class="float-left tx-11 text-muted">35 mins ago</a>-->
	<!--							<p class="mb-0 text-muted tx-12">1k New Sales</p>-->
	<!--						</li>-->
	<!--						<li class="mt-0"> <i class="ti-bar-chart-alt bg-success-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Toatal Revenue</span> <a href="#" class="float-left tx-11 text-muted">50 mins ago</a>-->
	<!--							<p class="mb-0 text-muted tx-12">23.5K New Revenue</p>-->
	<!--						</li>-->
	<!--						<li class="mt-0"> <i class="ti-wallet bg-warning-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Toatal Profit</span> <a href="#" class="float-left tx-11 text-muted">1 hour ago</a>-->
	<!--							<p class="mb-0 text-muted tx-12">3k New profit</p>-->
	<!--						</li>-->
	<!--						<li class="mt-0"> <i class="si si-eye bg-purple-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Customer Visits</span> <a href="#" class="float-left tx-11 text-muted">1 day ago</a>-->
	<!--							<p class="mb-0 text-muted tx-12">15% increased</p>-->
	<!--						</li>-->
	<!--						<li class="mt-0 mb-0"> <i class="icon-note icons bg-primary-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Customer Reviews</span> <a href="#" class="float-left tx-11 text-muted">1 day ago</a>-->
	<!--							<p class="mb-0 text-muted tx-12">1.5k reviews</p>-->
	<!--						</li>-->
	<!--					</ul>-->
	<!--				</div>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--		<div class="col-xl-4 col-md-12 col-lg-6">-->
	<!--			<div class="card">-->
	<!--				<div class="card-header pb-0">-->
	<!--					<h3 class="card-title mb-2">Recent Orders</h3>-->
	<!--					<p class="tx-12 mb-0 text-muted">An order is an investor's instructions to a broker or brokerage firm to purchase or sell</p>-->
	<!--				</div>-->
	<!--				<div class="card-body sales-info ot-0 pt-0 pb-0">-->
	<!--					<div id="chart" class="ht-150"></div>-->
	<!--					<div class="row sales-infomation pb-0 mb-0 mx-auto wd-100p">-->
	<!--						<div class="col-md-6 col">-->
	<!--							<p class="mb-0 d-flex"><span class="legend bg-primary brround"></span>Delivered</p>-->
	<!--							<h3 class="mb-1">5238</h3>-->
	<!--							<div class="d-flex">-->
	<!--								<p class="text-muted ">Last 6 months</p>-->
	<!--							</div>-->
	<!--						</div>-->
	<!--						<div class="col-md-6 col">-->
	<!--							<p class="mb-0 d-flex"><span class="legend bg-info brround"></span>Cancelled</p>-->
	<!--								<h3 class="mb-1">3467</h3>-->
	<!--							<div class="d-flex">-->
	<!--								<p class="text-muted">Last 6 months</p>-->
	<!--							</div>-->
	<!--						</div>-->
	<!--					</div>-->
	<!--				</div>-->
	<!--			</div>-->
	<!--			<div class="card ">-->
	<!--				<div class="card-body">-->
	<!--					<div class="row">-->
	<!--						<div class="col-md-6">-->
	<!--							<div class="d-flex align-items-center pb-2">-->
	<!--								<p class="mb-0">Total Sales</p>-->
	<!--							</div>-->
	<!--							<h4 class="font-weight-bold mb-2">$7,590</h4>-->
	<!--							<div class="progress progress-style progress-sm">-->
	<!--								<div class="progress-bar bg-primary-gradient wd-80p" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78"></div>-->
	<!--							</div>-->
	<!--						</div>-->
	<!--						<div class="col-md-6 mt-4 mt-md-0">-->
	<!--							<div class="d-flex align-items-center pb-2">-->
	<!--								<p class="mb-0">Active Users</p>-->
	<!--							</div>-->
	<!--							<h4 class="font-weight-bold mb-2">$5,460</h4>-->
	<!--							<div class="progress progress-style progress-sm">-->
	<!--								<div class="progress-bar bg-danger-gradient wd-75" role="progressbar"  aria-valuenow="45" aria-valuemin="0" aria-valuemax="45"></div>-->
	<!--							</div>-->
	<!--						</div>-->
	<!--					</div>-->
	<!--				</div>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--	</div>-->
		<!-- row close -->

		<!-- row opened -->
	<!--	<div class="row row-sm row-deck">-->
	<!--		<div class="col-md-12 col-lg-4 col-xl-4">-->
	<!--			<div class="card card-dashboard-eight pb-2">-->
	<!--				<h6 class="card-title">Your Top Countries</h6><span class="d-block mg-b-10 text-muted tx-12">Sales performance revenue based by country</span>-->
	<!--				<div class="list-group">-->
	<!--					<div class="list-group-item border-top-0">-->
	<!--						<i class="flag-icon flag-icon-us flag-icon-squared"></i>-->
	<!--						<p>United States</p><span>$1,671.10</span>-->
	<!--					</div>-->
	<!--					<div class="list-group-item">-->
	<!--						<i class="flag-icon flag-icon-nl flag-icon-squared"></i>-->
	<!--						<p>Netherlands</p><span>$1,064.75</span>-->
	<!--					</div>-->
	<!--					<div class="list-group-item">-->
	<!--						<i class="flag-icon flag-icon-gb flag-icon-squared"></i>-->
	<!--						<p>United Kingdom</p><span>$1,055.98</span>-->
	<!--					</div>-->
	<!--					<div class="list-group-item">-->
	<!--						<i class="flag-icon flag-icon-ca flag-icon-squared"></i>-->
	<!--						<p>Canada</p><span>$1,045.49</span>-->
	<!--					</div>-->
	<!--					<div class="list-group-item">-->
	<!--						<i class="flag-icon flag-icon-in flag-icon-squared"></i>-->
	<!--						<p>India</p><span>$1,930.12</span>-->
	<!--					</div>-->
	<!--					<div class="list-group-item border-bottom-0 mb-0">-->
	<!--						<i class="flag-icon flag-icon-au flag-icon-squared"></i>-->
	<!--						<p>Australia</p><span>$1,042.00</span>-->
	<!--					</div>-->
	<!--				</div>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--		<div class="col-md-12 col-lg-8 col-xl-8">-->
	<!--			<div class="card card-table-two">-->
	<!--				<div class="d-flex justify-content-between">-->
	<!--					<h4 class="card-title mb-1">Your Most Recent Earnings</h4>-->
	<!--					<i class="mdi mdi-dots-horizontal text-gray"></i>-->
	<!--				</div>-->
	<!--				<span class="tx-12 tx-muted mb-3 ">This is your most recent earnings for today's date.</span>-->
	<!--				<div class="table-responsive country-table">-->
	<!--					<table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">-->
	<!--						<thead>-->
	<!--							<tr>-->
	<!--								<th class="wd-lg-25p">Date</th>-->
	<!--								<th class="wd-lg-25p tx-right">Sales Count</th>-->
	<!--								<th class="wd-lg-25p tx-right">Earnings</th>-->
	<!--								<th class="wd-lg-25p tx-right">Tax Witheld</th>-->
	<!--							</tr>-->
	<!--						</thead>-->
	<!--						<tbody>-->
	<!--							<tr>-->
	<!--								<td>05 Dec 2019</td>-->
	<!--								<td class="tx-right tx-medium tx-inverse">34</td>-->
	<!--								<td class="tx-right tx-medium tx-inverse">$658.20</td>-->
	<!--								<td class="tx-right tx-medium tx-danger">-$45.10</td>-->
	<!--							</tr>-->
	<!--							<tr>-->
	<!--								<td>06 Dec 2019</td>-->
	<!--								<td class="tx-right tx-medium tx-inverse">26</td>-->
	<!--								<td class="tx-right tx-medium tx-inverse">$453.25</td>-->
	<!--								<td class="tx-right tx-medium tx-danger">-$15.02</td>-->
	<!--							</tr>-->
	<!--							<tr>-->
	<!--								<td>07 Dec 2019</td>-->
	<!--								<td class="tx-right tx-medium tx-inverse">34</td>-->
	<!--								<td class="tx-right tx-medium tx-inverse">$653.12</td>-->
	<!--								<td class="tx-right tx-medium tx-danger">-$13.45</td>-->
	<!--							</tr>-->
	<!--							<tr>-->
	<!--								<td>08 Dec 2019</td>-->
	<!--								<td class="tx-right tx-medium tx-inverse">45</td>-->
	<!--								<td class="tx-right tx-medium tx-inverse">$546.47</td>-->
	<!--								<td class="tx-right tx-medium tx-danger">-$24.22</td>-->
	<!--							</tr>-->
	<!--							<tr>-->
	<!--								<td>09 Dec 2019</td>-->
	<!--								<td class="tx-right tx-medium tx-inverse">31</td>-->
	<!--								<td class="tx-right tx-medium tx-inverse">$425.72</td>-->
	<!--								<td class="tx-right tx-medium tx-danger">-$25.01</td>-->
	<!--							</tr>-->
	<!--						</tbody>-->
	<!--					</table>-->
	<!--				</div>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--	</div>-->
		<!-- /row -->


	</div>
@endsection

