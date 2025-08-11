
<!doctype html>
<html lang="en" dir="rtl">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Title -->
    <title> أكاديمية اديوستديج |  @yield('title') </title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('back') }}/assets/img/brand/favicon.png" type="image/x-icon"/>

    <!-- Bootstrap css-->
	<link href="{{ asset('back') }}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- Icons css -->
    <link href="{{ asset('back') }}/assets/css-rtl/icons.css" rel="stylesheet">

    <!--  Right-sidemenu css -->
    <link href="{{ asset('back') }}/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

    <!-- P-scroll bar css-->
    <link href="{{ asset('back') }}/assets/plugins/perfect-scrollbar/p-scrollbar.css" rel="stylesheet" />

    <!-- Sidemenu css -->
    <link rel="stylesheet" href="{{ asset('back') }}/assets/css-rtl/sidemenu.css">
    
    <!-- bootstrap-duallistbox css -->
    <link rel="stylesheet" href="{{ asset('back') }}/assets/bootstrap-duallistbox.min.css">

    <!-- Style css -->
    <link href="{{ asset('back') }}/assets/css-rtl/style.css" rel="stylesheet">
    <link href="{{ asset('back') }}/assets/css-rtl/style-dark.css" rel="stylesheet">

    <!-- Maps css -->
    <link href="{{ asset('back') }}/assets/plugins/jqvmap/jqvmap.min.css" rel="stylesheet">

    <!--- Select2 css --->
    <link href="{{ asset('back') }}/assets/plugins/select2/css/select2.min.css" rel="stylesheet">

    <!-- Data table css -->
    <link href="{{ asset('back') }}/assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="{{ asset('back') }}/assets/plugins/datatable/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ asset('back') }}/assets/plugins/datatable/css/responsive.bootstrap4.min.css" rel="stylesheet" />
    <link href="{{ asset('back') }}/assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('back') }}/assets/plugins/datatable/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('back') }}/assets/plugins/select2/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css"/>

    {{-- alertify --}}
    <link href="{{ asset('back/assets/css-rtl/alertify.rtl.min.css') }}" type="text/css" rel="stylesheet"/>
    <link href="{{ asset('back/assets/css-rtl/default.rtl.min.css') }}" type="text/css" rel="stylesheet"/>

    <!-- selectize -->
    <link href="{{ asset('back/assets/selectize.css') }}" type="text/css" rel="stylesheet"/>

    {{-- flatpickr --}}
    <link rel="stylesheet" href="https://unpkg.com/flatpickr/dist/flatpickr.min.css">

    {{-- spotlight --}}
    <link href="{{ asset('back/assets/spotlight.min.css') }}" rel="stylesheet" type="text/css" />


    @yield('header')

    <!-- Skinmodes css -->
    <link href="{{ asset('back') }}/assets/css-rtl/skin-modes.css" rel="stylesheet" />

    <!-- Animations css -->
    <link href="{{ asset('back') }}/assets/css-rtl/animate.css" rel="stylesheet">

    <!---Switcher css-->
    <link href="{{ asset('back') }}/assets/switcher/css/switcher-rtl.css" rel="stylesheet">
    <link href="{{ asset('back') }}/assets/switcher/demo.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Cairo:slnt,wght@11,200..1000&family=Changa:wght@200..800&display=swap" rel="stylesheet">

    <style>
        @font-face {
            font-family: "4_F4";
            src: url("{{ asset('back/fonts/4_F4.ttf') }}");
        }
        body{
            font-family: Arial, Helvetica, sans-serif, serif; */
            font-family: "4_F4", serif;
            font-family: Almarai;
        }

        /*body{
            font-family: "4_F4", serif;
        }*/

        table.dataTable tbody th, table.dataTable tbody td{
            padding: 5px 5px 1px !important;
        }

        .breadcrumb-header .content-title{
            font-size: 16px !important;
            font-weight: bold !important;
        }

        table.table-bordered.dataTable tbody th, table.table-bordered.dataTable tbody td{
            font-size: 11px !important;
            font-weight: bold !important;
        }

        .modal form label {
            font-size: 12px !important;
            font-weight: bold;
        }

        .modal form .text-danger{
            font-size: 11px;
            font-weight: bold;
        }

        #image_preview_form{
            display: block;
            height: 200px;
            width: 70%;
            margin: 0px auto;
            margin-top: -50px;
            border-radius: 3px;
            border: 1px solid #d7d7d7;
        }

        @media (min-width: 768px) {
            #image_preview_form{
                height: 293px;
                display: block;
                width: 100%;
                margin-top: 66px;
                border-radius: 3px;
                border: 1px solid #d7d7d7;
            }
        }

        .numInputWrapper span.arrowDown {
            top: 30%;
        }
        .side-menu__label{
            font-weight: bold !important;
            font-size: 10.5px;
        }

        .slide-item{
            font-size: 10.5px;
        }

        .app-sidebar .side-item.side-item-category{
            font-size: 10.5px !important;
            font-weight: bold !important;
            color: #bf0001;
        }
        .slide.is-expanded .angle, .slide.is-expanded .side-menu__icon, .slide.is-expanded .side-menu__label{
            color: #fff !important;
        }

        @media (min-width: 768px) {
            .app.sidenav-toggled .side-menu__label {
                font-size: 10.5px !important;
            }
        }

        .spl-title{
            text-align: center !important;
        }

        #example1_processing{
            padding: 10px 10px 35px !important;
            border: 2px solid red !important;
            color: red !important;
        }

        .sidebar_icon{
            position: relative;
            bottom: 1px;
            font-size: 20px;
            margin-left: 3px;
        }


        .side-menu__item.active i,
        .side-menu__item:focus i,
        .side-menu__item:hover i,
        .side-menu__item:hover {
            color: rgb(255, 255, 255) !important;
        }

        .slide-item.active, .slide-item:focus, .slide-item:hover{
            color: #fff !important;
            background: #00000033;
        }

        .app-sidebar__user .user-pro-body{
            padding: 0 0 15px !important;
        }

        table tbody .btn-sm{
            width: 25px;
            height: 18px;
            text-align: center;
            padding: 0 
        }

        #navbar_search_time_table{
            position: absolute;
            width: 500px;
            right: 14px;
            max-height: 300px;
            overflow: auto;
            display: none;
        }

        #navbar_search_time_table thead th{
            font-size: 9px;
        }

        #navbar_search_time_table table{
            height: 250px;
            overflow: auto;
            display: block;
            display: none;
        }

        #navbar_search_time_table table .reserved{
            background: #353535;
            color: #fff;
            border: 2px solid red;
        }

        #navbar_search_time_table table .substitute {
            color: red;
            border: 3px solid red;
        }

        #navbar_spinner{
            position: absolute;
            left: 470px;
            bottom: 9px;
            width: 1.5rem;
            height: 1.5rem;
            display: none;
            top: 1px !important;
        }

        .main-profile-menu .profile-user img{
            width: 33px !important;
            height: 33px !important;
        }

        #navbar_search_time_table tbody td{
            font-size: 9px;
            font-weight: bold;
            padding: 6px 0px 0px;
        }
        .modal-header{
            padding: .5rem 1rem !important;
        }
        
        .modal-footer{
            padding: .5rem 1rem 0 !important;
        }

        input::placeholder {
            font-size: 10px !important;
            position: relative;
            top: -2px;
        }

        .selectize-input, input, select{
            height: 35px !important;
            padding: 2px 8px !important
        }

        .right-content .add{
            padding: 0 !important;
            width: 30px !important;
            height: 25px !important;
        }

        .form-control, .selectize{
            color: #000 !important;
            font-weight: bold;
            font-size: 11px !important;
        }
        table tbody .dropdown{
            position: absolute !important;
        }
        table tbody .dropdown-menu{
            background: #e2eaae;
        }

        table tbody .dropdown-menu button, a{
            font-weight: bold !important;
        }

        .alertify .ajs-dialog{
            background-color: #e7d0d0 !important;
        }

        .form-control:disabled, .form-control[readonly] {
            background-color: #61616124;
        }
        .datePicker:disabled, .datePicker[readonly] {
            background-color: #d9d9d9 !important;
            border: 1px solid #0000004d !important;
        }

        @media (max-width: 574px) {
            .responsive-logo .logo-2 {
                dispLay: block;
                height: 1.5rem !important;
            }
        }

        @media (min-width: 768px) {
            .sidenav-toggled .app-sidebar__user {
                /* padding: 12px 0 12px 0; */
                margin-bottom: 0;
                border-bottom: 0;
            }
        }

        @media (min-width: 768px) { /* mini logo in sidebar */
            .app.sidebar-mini.sidenav-toggled .logo-icon {
                display: block !important;
                height: 2rem;
            }
        }

        /*.btn-sm{padding:.25rem .5rem;font-size:.875rem;line-height:1.5;border-radius:.2rem}*/

        /*.slide-item {
            color: #004ceb !important;
        }*/

        /*.slide.is-expanded .side-menu__icon, .slide.is-expanded .side-menu__label{
            background:rgb(209, 56, 56) !important;
            padding: 6px 4px;
            color: #fff !important;
        }

        .side-menu__item:hover i{
            color:rgb(209, 56, 56) !important;
        }
        
*/







        /* ////////////////////////////////////////////  top css new css edit  ///////////////////////////////////////////////// */





        .require_input{
            font-size: 7px;
            position: absolute;
            left: 15px;
            top: 17px;
            color: red;
        }

        .breadcrumb-header {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .dataTables_wrapper .dataTables_info {
            margin-top: 29px !important;
        }

        .dataTables_length{
            margin-left: 10px;
        }

        table .edit, table .delete, table .show, table .crm_info, table .print, table .take_attendance, table .remove_student_tbl_groups_students, .remove_one_student{
            padding: 0 6px !important;
        }

        .ajs-button {
            border: 0px;
            font-weight: bold;
        }

        .ajs-ok{
            background-color: #d7d7d7 !important;
        }

        .ajs-cancel {
            background: rgb(209, 56, 56) !important;
            color: #fff !important;
        }

        .ajs-success{
            font-weight: bold;
            width: 450px !important;
            background: rgb(77, 124, 91) !important;
        }

        .ajs-error{
            font-weight: bold;
            width: 450px !important;
            background: rgb(155, 56, 64) !important;
        }

        .modal form label{
            margin-top: 10px !important;
        }
        .modal form input::placeholder{
            font-size: 12px;
        }

        .sub-icon{
            color: rgb(37, 37, 37) !important;
            font-weight: bold !important;
        }
        .slide-item{
            font-weight: bold !important;
        }

        .slide.is-expanded .side-menu__item{
            background: rgb(10 10 10 / 75%);
        }
        .side-menu__item:hover{
            background: rgb(10 10 10 / 75%);
        }


        .spinner_request, .spinner_request2{
            width: 1.4rem;
            height: 1.4rem;
            border-width: 0.2em;
            position: relative;
            bottom: 2px;
            right: 5px;
            display: none;
        }

        .alertify{
            z-index:999999 !important;
            display: block !important;
        }

        .alertify-notifier{
            z-index:999999 !important;
        }

        #overlay_page {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* خلفية شفافة */
            z-index: 1000000; /* أعلى من كل العناصر الأخرى */
            display: none; /* مخفي في البداية */
            justify-content: center;
            align-items: center;
        }

        #overlay_page::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 8px solid #fff;
            border-top: 8px solid #007bff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }
        .nowrap_thead{
            white-space: nowrap;
        }
        .badge{
            font-size: 90% !important;
        }

        .main-header{
            height: 35px !important;
        }

        .modal-dialog {
            max-height: 100vh;
            margin: 0 auto;
            display: flex;
            align-items: center;
        }

        .modal-content {
            max-height: 100vh;
            overflow-y: auto;
        }

        .dt-buttons .btn {
            border-radius: 3px !important;
            padding: 5px 9px;
            margin: 0 5px;
            font-weight: bold;
            font-size: 10px;
        }

        .dt-buttons .dropdown-item.active, .dropdown-item:active{
            padding: 5px 9px;
            font-size: 10px;
        }

        .bg-primary {
            background-color: #5066e0 !important;
        }

         /* start Scrollbar */
            ::-webkit-scrollbar:vertical {
                width: 8px;
            }
            ::-webkit-scrollbar-track:vertical {
                background: #eee;
            }
            ::-webkit-scrollbar-thumb:vertical {
                background: #666;
                border-radius: 6px;
                transition: background 0.3s ease;
            }
            ::-webkit-scrollbar-thumb:vertical:hover {
                background: #5066e0;
            }
            ::-webkit-scrollbar:horizontal {
                height: 8px;
            }
            ::-webkit-scrollbar-track:horizontal {
                background: #f9f9f9;
            }
            ::-webkit-scrollbar-thumb:horizontal {
                background: #999;
                border-radius: 6px;
                transition: background 0.3s ease;
            }
            ::-webkit-scrollbar-thumb:horizontal:hover {
                background: #5066e0;
            }
         /* end Scrollbar */

        table.dataTable thead th, table.dataTable thead td {
            padding: 7px 18px !important;
            background: #5066e0 !important;
            color: #fff !important;
        }
        table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc{
            background-color: #c25f00b0 !important;
            color: #fff;
        }
        table.dataTable tbody td.sorting_1{
            background-color: #c9640517 !important;
        }
    </style>
</head>

    <body class="main-body app sidebar-mini {{-- dark-theme --}}">

    	@php  $userInfoFromAdminTable = App\Models\Back\Admin::where('user_id', auth()->user()->id)->first(); @endphp
        <!-- Start Switcher -->
        @include('back.layouts.switcher')
        <!-- End Switcher -->

        <!-- Loader -->
        <div id="global-loader">
            <img src="{{ asset('back') }}/assets/img/loader.svg" class="loader-img" alt="Loader">
        </div>
        <!-- /Loader -->

        <!-- Page -->
        <div class="page">

            <!-- main-sidebar -->
            @include('back.layouts.sidebar')
			<!-- main-sidebar -->

            <!-- main-content -->
			<div class="main-content app-content" style="background: #e9e9ff !important;">

                <!-- main-header -->
                @include('back.layouts.navbar')
				<!-- /main-header -->

                <div id="overlay_page"></div>

                <!-- container -->
                @yield('content')
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->

            <!-- Sidebar-right-->
            @include('back.layouts.right_sidebar')
			<!--/Sidebar-right-->

            <!-- Footer opened -->
            @include('back.layouts.footer')
			<!-- Footer closed -->
        </div>
		<!-- End Page -->



        <!-- Back-to-top -->
        <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

        <!-- JQuery min js -->
        <script src="{{ asset('back') }}/assets/plugins/jquery/jquery.min.js"></script>

        <!-- Bootstrap js -->
        <script src="{{ asset('back') }}/assets/plugins/bootstrap/js/popper.min.js"></script>
        <script src="{{ asset('back') }}/assets/plugins/bootstrap/js/bootstrap-rtl.js"></script>

        <!-- Ionicons js -->
        <script src="{{ asset('back') }}/assets/plugins/ionicons/ionicons.js"></script>

        <!-- Moment js -->
        <script src="{{ asset('back') }}/assets/plugins/moment/moment.js"></script>

        <!-- P-scroll js -->
        <script src="{{ asset('back') }}/assets/plugins/perfect-scrollbar/perfect-scrollbar.min-rtl.js"></script>
        <script src="{{ asset('back') }}/assets/plugins/perfect-scrollbar/p-scroll-rtl.js"></script>

        <!-- Sticky js -->
        <script src="{{ asset('back') }}/assets/js/sticky.js"></script>
        
        <!-- bootstrap-duallistbox.min js -->
        <script src="{{ asset('back') }}/assets/jquery.bootstrap-duallistbox.min.js"></script>

        <!-- eva-icons js -->
        {{-- <script src="{{ asset('back') }}/assets/js/eva-icons.min.js"></script> --}}

        <!-- Horizontalmenu js-->
        <script src="{{ asset('back') }}/assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>

        <!-- Rating js-->
        <script src="{{ asset('back') }}/assets/plugins/rating/jquery.rating-stars.js"></script>
        <script src="{{ asset('back') }}/assets/plugins/rating/jquery.barrating.js"></script>

        <!-- Sidebar js -->
        <script src="{{ asset('back') }}/assets/plugins/side-menu/sidemenu.js"></script>

        <!-- Right-sidebar js -->
        <script src="{{ asset('back') }}/assets/plugins/sidebar/sidebar-rtl.js"></script>
        <script src="{{ asset('back') }}/assets/plugins/sidebar/sidebar-custom.js"></script>


		<!--Internal  Chart.bundle js -->
		<script src="{{ asset('back') }}/assets/plugins/chart.js/Chart.bundle.min.js"></script>

		<!--Internal Sparkline js -->
		<script src="{{ asset('back') }}/assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

		<!-- Raphael js -->
		<script src="{{ asset('back') }}/assets/plugins/raphael/raphael.min.js"></script>

		<!-- Internal Map -->
		<script src="{{ asset('back') }}/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
		<script src="{{ asset('back') }}/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>

		<!--Internal  index js -->
		<script src="{{ asset('back') }}/assets/js/index.js"></script>
		<script src="{{ asset('back') }}/assets/js/jquery.vmap.sampledata.js"></script>

    <!--Internal  Datepicker js -->
    <script src="{{ asset('back') }}/assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>

    <!-- Internal Select2 js-->
    <script src="{{ asset('back') }}/assets/plugins/select2/js/select2.min.js"></script>

    <!-- Internal Modal js-->
    <script src="{{ asset('back') }}/assets/js/modal.js"></script>

    <!-- Data tables -->
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/dataTables.dataTables.min.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/responsive.dataTables.min.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/jquery.dataTables.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/dataTables.bootstrap4.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/jszip.min.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/pdfmake.min.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/vfs_fonts.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/buttons.html5.min.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/buttons.print.min.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('back') }}/assets/plugins/datatable/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('back') }}/assets/js/table-data.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.js"></script>

    <!-- alertify -->
    <script src="{{ asset('back/assets/js/alertify.min.js') }}"></script>


    {{-- general scripts file js --}}
    @include('back.layouts.general_scripts')


    {{-- selectize --}}
    <script src="{{ asset('back/assets/selectize.min.js') }}"></script>

    {{-- flatpickr --}}
    <script src="https://unpkg.com/flatpickr/dist/flatpickr.min.js"></script>

    <!-- spotlight -->
    <script src="{{ asset('back/assets/spotlight.bundle.js') }}"></script>
    <script src="{{ asset('back/assets/spotlight.min.js') }}"></script>



    <script>
        $('#getDataByAcademicYear').on('change', function(){
            const thisVal = $(this).val();
            
            $.ajax({
                type: 'get',
                url: `{{ url('users/changeAcademucYear') }}/${thisVal}`, 
                success: function(res){
                    location.reload();
                    
                }
            });
            
        });

        // start when input number focused
        $(document).on('focus', 'input[type="number"], .focused, .focus_input', function() {
            $(this).select();
        });
        // end when input number focused
        
        // start when tr in datatable clicked
        $(document).on('click', '#example1 tbody tr', function () {
            $('#example1 tbody tr').removeClass('selected').css('background-color', '');
            $(this).addClass('selected').css('background-color', 'yellow');
        });

        // end when tr in datatable clicked
        
        //localStorage.setItem("reloadTabs", Date.now());
        //window.addEventListener("storage", function (event) {
        //    if (event.key === "reloadTabs") {
        //        location.reload();
        //    }
        //});
    </script>


    @yield('footer')

    <!-- custom js -->
    <script src="{{ asset('back') }}/assets/js/custom.js"></script>

    <!-- Helper js -->
    <script src="{{ asset('back') }}/assets/helpers.js"></script>
    
    <!-- Switcher js -->
	<script src="{{ asset('back') }}/assets/switcher/js/switcher-rtl.js"></script>
</body>
</html>
