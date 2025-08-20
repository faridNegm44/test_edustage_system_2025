<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
	<aside class="app-sidebar sidebar-scroll" style="background: #5066e0;">
		<div class="main-sidebar-header active" style="background: #5066e0;border: 0 !important">
			<a class="desktop-logo logo-light active" href="{{ url('/') }}">
				<img src="{{ asset('back/images/settings/'.GeneralSettingsInfo()->logo_dashboard) }}" class="main-logo" alt="logo">
			</a>
			<a class="desktop-logo logo-dark active" href="{{ url('/') }}">
				<img src="{{ asset('back/images/settings/'.GeneralSettingsInfo()->logo_dashboard) }}" class="main-logo dark-theme" alt="logo">
			</a>
			<a class="logo-icon mobile-logo icon-light active" href="{{ url('/') }}">
				<img src="{{ asset('back/images/settings/min_logo.png') }}" class="logo-icon" alt="logo">
			</a>
			<a class="logo-icon mobile-logo icon-dark active" href="{{ url('/') }}">
				<img src="{{ asset('back/images/settings/min_logo.png') }}" class="logo-icon dark-theme" alt="logo">
			</a>
		</div>
		<div class="main-sidemenu">
			<div class="app-sidebar__user clearfix">
				<div class="dropdown user-pro-body">
					{{-- <div class="">
						<img alt="user-img" class="avatar brround" src="{{ asset('back') }}/assets/img/faces/6.jpg"><span class="avatar-status profile-status bg-green"></span>
					</div> --}}
					<div class="user-info">
						<img alt="user-img" class="avatar brround" src="{{ asset('back') }}/images/users/{{ !$userInfoFromAdminTable ? 'df_image.png' : $userInfoFromAdminTable->image }}" style="display: inline;">
						<h4 class="font-weight-bold mt-3 mb-0" style="display: inline;position: relative;top: 2px;right: 4px;text-decoration: underline;color: #fff;">{{ auth()->user()->name }}</h4>
						<br>
						{{-- <span class="mb-0 text-muted">
							@if (auth()->user()->user_status == 1)
								مدير
							@elseif (auth()->user()->user_status == 2)
								موظف
							@elseif (auth()->user()->user_status == 4)
								مدرس
							@endif
						</span> --}}
					</div>
				</div>
			</div>
























			@if(auth()->user()->user_status === 1 || auth()->user()->user_status === 2)	{{-- routes super admin and admin --}}
				<ul class="side-menu">
					{{-- <li class="side-item side-item-category">إدارة علاقات العملاء</li> --}}

					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-info-circle text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">معلومات أولية</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							<li><a class="slide-item text-light" href="{{ url('academic_years') }}">سنوات الأكاديمية</a></li>
							<li><a class="slide-item text-light" href="{{ url('rooms') }}">الغرف الدراسية</a></li>
							{{--<li><a class="slide-item text-light" href="23">مواعيد الغرف الدراسية</a></li>--}}
							<li><a class="slide-item text-light" href="{{ url('types_of_education') }}">أنواع التعليم</a></li>
							<li><a class="slide-item text-light" href="{{ url('nationalities') }}">الجنسيات</a></li>
							<li><a class="slide-item text-light" href="{{ url('places_of_stay') }}">أماكن الٌاقامة</a></li>
							<li><a class="slide-item text-light" href="{{ url('teachers') }}">المدرسون</a></li>
							<li><a class="slide-item text-light" href="{{ url('partners') }}">الشركاء</a></li>
							<li><a class="slide-item text-light" href="{{ url('crm/columns_name') }}">قسم جديد لإدارة علاقات العملاء</a></li>
						</ul>
					</li>
					
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-graduation-cap text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">معلومات الطلبة والصفوف</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							<li><a class="slide-item text-light" href="{{ url('subjects') }}">الصفوف و المواد الدراسية</a></li>
							<li><a class="slide-item text-light" href="{{ url('parents') }}">أولياء الأمور</a></li>
							<li><a class="slide-item text-light" href="{{ url('students') }}">الطلاب</a></li>
							<li><a class="slide-item text-light" href="{{ url('students_wishlist') }}">لائحة رغبات الطلاب</a></li>
							{{--<li><a class="slide-item text-light" href="{{ url('class_rooms') }}">الصفوف الدراسية</a></li>--}}
						</ul>
					</li>
					
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-star text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">العمليات الرئيسية</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							{{--<li><a class="slide-item text-light" href="{{ url('price_list') }}">جدول الأسعار</a></li>--}}
							<li><a class="slide-item text-light" href="{{ url('teacher_accounting_type') }}">طريقة حساب المدرس</a></li>
							<li><a class="slide-item text-light" href="{{ url('groups') }}">المجموعات التعليمية</a></li>
						</ul>
					</li>
					
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-money-bill-alt text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">العمليات المالية</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							<li><a class="slide-item text-light" href="{{ url('parent-payments') }}">متحصلات من أولياء الأمور</a></li>
							<li><a class="slide-item text-light" href="{{ url('teacher-salaries') }}">أجور المدرسين</a></li>
							<li><a class="slide-item text-light" href="{{ url('financial_categories') }}">تصنيفات العمليات المالية</a></li>
							<li><a class="slide-item text-light" href="12f34">العمليات المالية</a></li>									
							<li><a class="slide-item text-light" href="{{ url('partners_payments') }}">مسحوبات الشركاء</a></li>
							<li><a class="slide-item text-light" href="{{ url('wallets') }}">المحافظ</a></li>
							<li><a class="slide-item text-light" href="12w34">تعديل تفقد طالب</a></li>
						</ul>
					</li>


					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-chalkboard-teacher text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">المدرسون</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
								<li><a class="slide-item text-light" href="{{ url('teachers') }}">جميع المدرسون</a></li>
						</ul>
					</li>

					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-medal text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">تقييم الطلاب الشهري</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							<li><a class="slide-item text-light" href="{{ url('students_estimates') }}">اداره تقييم الطلاب الشهري</a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="slide-item text-light" href="{{ url('students_estimates/student_report') }}">تقرير تقييم طالب</a></li>
							<li><a class="slide-item text-light" href="{{ url('students_estimates/groups_report') }}">تقرير تقييم مجموعة</a></li>
							<li><a class="slide-item text-light" href="{{ url('students_estimates/groups_rated_report') }}">تقرير لجروبات تم تقييمها</a></li>
							<li><a class="slide-item text-light" href="{{ url('students_estimates/groups_not_rated_report') }}">تقرير لجروبات لم يتم تقييمها</a></li>
						</ul>
					</li>

					{{-- <li class="side-item side-item-category">جدول الحصص + الأوقات</li> --}}
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-calendar-alt text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">جدول الحصص / الأوقات</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							<li><a class="slide-item text-light" href="{{ url('time_table') }}">جدول الحصص</a></li>
							<li><a class="slide-item text-light" href="{{ url('time_table_history') }}">سجل جدول الحصص</a></li>
							<li><a class="slide-item text-light" href="{{ url('time_table/teacher_report') }}">تقرير حصص المدرس</a></li>
							<li><a class="slide-item text-light" href="{{ url('time_table/groups_report') }}">تقرير حصص لجروب</a></li>
							<li><a class="slide-item text-light" href="{{ url('times') }}">الأوقات</a></li>
						</ul>
					</li>
					
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="href="{{ url('time_table_ramadan_month') }}">
							<i class="fas fa-moon text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">جدول الحصص شهر رمضان</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							<li><a class="slide-item text-light" href="{{ url('time_table_ramadan_month') }}">جدول الحصص</a></li>
							<li><a class="slide-item text-light" href="{{ url('time_table_ramadan_month_history') }}">سجل جدول الحصص</a></li>
							<li><a class="slide-item text-light" href="{{ url('time_table_ramadan_month/teacher_report') }}">تقرير حصص المدرس</a></li>
							<li><a class="slide-item text-light" href="{{ url('time_table_ramadan_month/groups_report') }}">تقرير حصص لجروب</a></li>
						</ul>
					</li>

					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-users-cog text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">المستخدمين</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							<li><a class="slide-item text-light" href="{{ url('users') }}">المستخدمين</a></li>
						</ul>
					</li>

					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-copy text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">تقارير أولياء الأمور والطلاب</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							<li><a class="slide-item text-light" href="11">كشف حساب ولي أمر</a></li>
							<li><a class="slide-item text-light" href="{{ url('parent-payments/report') }}">كشف مدغوعات ولي أمر</a></li>
							<li><a class="slide-item text-light" href="{{ url('parents/report/attendance') }}">كشف تفقد</a></li>
							<li><a class="slide-item text-light" href="11111">كشف عام</a></li>
						</ul>
					</li>
					
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-copy text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">تقارير المدرسون</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							<li><a class="slide-item text-light" href="1">كشف حسابات المدرسين العام</a></li>
							<li><a class="slide-item text-light" href="2">كشف مدرس تفصيلي - نسبة</a></li>
							<li><a class="slide-item text-light" href="3">كشف مدرس تفصيلي - قيمة ثابتة</a></li>
							<li><a class="slide-item text-light" href="{{ url('teacher-salaries/report') }}">كشف مدفوعات المدرسين</a></li>
							<li><a class="slide-item text-light" href="{{ url('teachers/report/students_classes') }}">كشف حصص الطلاب</a></li>
							<li><a class="slide-item text-light" href="{{ url('teachers/report/commitment') }}">كشف إلتزام المدرسين</a></li>
						</ul>
					</li>
					
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-copy text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">تقارير أخري</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							<li><a class="slide-item text-light" href="{{ url('report/general-financial') }}">الكشف المالي العام</a></li>
							<li><a class="slide-item text-light" href="8">الحركة المالية</a></li>
							<li><a class="slide-item text-light" href="9">الطلاب وآخر حضور</a></li>
						</ul>
					</li>

					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-cog text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">الإعدادات</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							<li><a class="slide-item text-light" href="{{ url('roles_permissions') }}">الأذونات والتراخيص</a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="slide-item text-light" href="{{ url('general_settings') }}">الإعدادات العامة</a></li>
						</ul>
					</li>

				</ul>







			@elseif(auth()->user()->user_status === 4)	{{-- routes teacher --}}
				<ul class="side-menu">
					<br />
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-chalkboard-teacher text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">المجموعات التعليمية</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							<li><a class="slide-item text-light" href="{{ url('students_estimates') }}">تقييم الطلاب</a></li>
							{{-- <li><a class="slide-item text-light" href="{{ url('students_estimates/student_report') }}">تقرير تقييم طالب</a></li>
							<li><a class="slide-item text-light" href="{{ url('students_estimates/groups_report') }}">تقرير تقييم مجموعة</a></li> --}}
						</ul>
					</li>

					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-calendar-alt text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">جدول الحصص / الأوقات</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							<li><a class="slide-item text-light" href="{{ url('time_table') }}">جدول الحصص</a></li>
							{{--  <li><a class="slide-item text-light" href="{{ url('time_table_history') }}">سجل جدول الحصص</a></li>
							<li><a class="slide-item text-light" href="{{ url('time_table/teacher_report') }}">تقرير حصص المدرس</a></li>
							<li><a class="slide-item text-light" href="{{ url('time_table/groups_report') }}">تقرير حصص لجروب</a></li>
							<li><a class="slide-item text-light" href="{{ url('times') }}">الأوقات</a></li>  --}}
						</ul>
					</li>
				</ul>







			@elseif(auth()->user()->user_status === 3)	{{-- routes parent --}}
				<ul class="side-menu">
					{{-- <li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fas fa-user-tie text-light sidebar_icon"></i>
							<span class="side-menu__label text-light">أولياء الأمور</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							<li><a class="slide-item text-light" href="{{ url('parents') }}">جميع أولياء الأمور</a></li>
						</ul>
					</li> --}}
				</ul>







			@endif
		</div>
	</aside>
