
@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    <style>
        .main_tr_day{
            background: #838080 !important;
            color: #fff;
        }

        .main_hour{
            background: #838080 !important;
            color: #fff !important;
        }

        table.dataTable thead th, table.dataTable thead td{
            padding: 5px 10px !important;
            border: 1px solid #838080 !important;
            font-size: 12px !important;
            width: 25px !important;
        }

        .ajs-success, .ajs-error{
            width: 380px !important;
        }


        .table-wrapper {
            position: relative;
            max-height: calc(100vh - 100px);
            overflow-y: auto;
        }

        .table thead th {
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .table tbody th:not(:first-child) {
            font-size: 10px !important;
            font-weight: bold;
            width: 25px !important;
            max-width: 30px !important;
            padding: 3px 0 0 0 !important;
        }

        table.table-bordered.dataTable th, table.table-bordered.dataTable td{
            max-width: 30px !important;
        }



        /*table td:nth-child(odd), table th:nth-child(odd) {
            background-color: #ffeb3b;
        }

        table td:nth-child(even), table th:nth-child(even) {
            background-color: #4caf50;
        }*/



        table tbody tr:nth-child(odd):hover {
            background-color: #364261;
        }

        table tbody tr:nth-child(even):hover {
            background-color: #c25710;
        }
    </style>


@endsection

@section('footer')
    <script>
        $("body").addClass('sidenav-toggled');

        // flatpickr
        flatpickr(".datePicker", {
            enableTime: false,
            noCalendar: false,
            minDate: "today",
            locale: {
                firstDayOfWeek: 6, // Saturday is the first day of the week.
                weekdays: {
                    shorthand: ["أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت"],
                    longhand: ["الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"]
                },
                months: {
                    shorthand: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
                    longhand: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"]
                },
                ordinal: () => { return "th"; }, // Not applicable in Arabic
                rangeSeparator: " إلى ",
                weekAbbreviation: "أسبوع",
                scrollTitle: "قم بالتمرير لتغيير",
                toggleTitle: "انقر لتغيير",
                closeText: "إغلاق",
                firstDayOfWeek: 6, // Saturday
            },
            dateFormat: "Y-m-d", // You can change the date format as needed
        });

        // open modal when click button (insert)
        document.addEventListener('keydown', function(event){
            if( event.which === 45 ){
                $('#exampleModalCenter').modal('show');
                document.querySelector('#exampleModalCenter .modal-header .modal-title').innerText = 'إضافة';
                document.querySelector('#exampleModalCenter .modal-footer #save').setAttribute('style', 'display: inline;');
                document.querySelector('#exampleModalCenter .modal-footer #update').setAttribute('style', 'display: none;');
                $('.dataInput').val('');
            }
        });

        // cancel enter button
        $(document).keypress(function (e) {
            if(e.which == 13){
                e.preventDefault();
            }
        });

        // selectize
        $('.selectize').selectize();


        // when close modal either add modal or edit
        $('#exampleModalCenter, #editModal').on('hidden.bs.modal', function () {
            var hasDisabledOption = $('#addForm option:disabled').length > 0;
            if(!hasDisabledOption){
                $("#addForm #times option").remove();
            }
            $("#addForm #group_id")[0].selectize.clear();

            $("#editForm #times option").remove();
            $("#editForm #group_id")[0].selectize.clear();
        });
    </script>


    <script>
        // when change any option off day or room or user or class_type off any modal either add or edit
        $('#addForm #day, #addForm #room_id, #addForm #user, #editForm #day, #editForm #room_id, #editForm #user').on('change', function(){
            $("#addForm #times option").remove();
            $("#editForm #times option").remove();
        });
    </script>



    {{-- start colspan and datatable options --}}
    <script>
        $(document).ready(function() {
            let daysDatatable = ['satDataTable', 'sunDataTable', 'monDataTable', 'tueDataTable', 'wedDataTable', 'thuDataTable', 'friDataTable'];

            $(daysDatatable).each(function(index, value){

                // datatable
                $(`#${value}`).DataTable({
                    fixedColumns: {
                        start: 1
                    },
                    ordering: false,
                    paging: false,
                    info: false,
                });


                $(`#${value} tbody tr th`).each(function() {
                    if ($(this).attr('data-original-title')) {

                        $(this).attr('colspan', $(this).data('count_colspan'));
                        $(this).html($(this).attr('data-title'));

                        for (var i = 1; i < $(this).data('count_colspan'); i++){
                            $(this).next('th').remove();
                        }
                    }
                });

            });
        });
    </script>
    {{-- end colspan and datatable options --}}




    {{-- start highlight column when click to th in thead --}}
    <script>
        $(document).ready(function() {
            $('table').on('click', 'thead th:not(:first-child)', function() {
                const thisDataColumnId = $(this).data('column_id');
                const table = $(this).closest('table');

                table.find(`tbody tr th[data-column_id_tbody="${thisDataColumnId}"]`).each(function() {
                    const currentBackground = $(this).css('background-color');

                    if (currentBackground === 'rgb(226, 228, 82)') {
                        $(this).css('background', '');
                    } else {
                        $(this).css('background', '#e2e452');
                    }
                });
            });
        });
    </script>
    {{-- end highlight column when click to th in thead --}}



    {{-- start get available times after select day + room + user in ADD FORM --}}
    @include('back.time_table_ramadan_month.add')
    {{-- end get available times after select day + room + user in ADD FORM --}}



    {{-- start get available times after select day + room + user in Edit FORM --}}
    @include('back.time_table_ramadan_month.edit')
    {{-- end get available times after select day + room + user in Edit FORM --}}



    {{-- start remove recorded times from database --}}
    @include('back.time_table_ramadan_month.delete')
    {{-- end remove recorded times from database --}}


    {{--  start open and closed all according   --}}
    <script>
        $(document).ready(function() {
            $(".main-header").addClass("bg bg-warning-gradient");
            $(".main-content").addClass("bg bg-warning-gradient");

            $("#openAll").click(function() {
                $(".panel-collapse").collapse("show");
            });

            $("#closeAll").click(function() {
                $(".panel-collapse").collapse("hide");
            });
        });
    </script>
    {{--  end open and closed all according   --}}
@endsection

@section('content')
    <div class="container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">
                        {{ $pageNameAr }} 
                        <i class="fas fa-moon text-white" style="font-size: 25px;"></i>
                    </h4>
                </div>
            </div>
            <div class="d-flex my-xl-auto right-content">
                <button type="button" style="margin: 0 2px;" id="openAll" class="btn btn-success btn-sm btn-rounded"><i class="fas fa-lock-open"></i></button>
                <button type="button" style="margin: 0 2px 0 10px;" id="closeAll" class="btn btn-secondary btn-sm btn-rounded"><i class="fas fa-lock"></i></button>

                <div class="pr-1 mb-xl-0">
                    <button type="button" class="btn btn-danger btn-icon ml-2 add" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter"><i class="mdi mdi-plus"></i></button>
                </div>
            </div>
        </div>
        <!-- breadcrumb -->


        @include('back.time_table_ramadan_month.form')
        @include('back.time_table_ramadan_month.edit_form')

        @php
            use Carbon\Carbon;
            $todayName = Carbon::now()->format('l');
        @endphp

        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="panel-group1" id="accordion11">








                    {{--//////////////////////////////////////////////////// start sat table /////////////////////////////////////////////////////////--}}
                    @include('back.time_table_ramadan_month.days.sat')
                    {{--//////////////////////////////////////////////////// end sat table /////////////////////////////////////////////////////////--}}







                    {{--//////////////////////////////////////////////////// start sun table /////////////////////////////////////////////////////////--}}
                    @include('back.time_table_ramadan_month.days.sun')
                    {{--//////////////////////////////////////////////////// end sun table /////////////////////////////////////////////////////////--}}








                    {{--//////////////////////////////////////////////////// start mon table /////////////////////////////////////////////////////////--}}
                    @include('back.time_table_ramadan_month.days.mon')
                    {{--//////////////////////////////////////////////////// end mon table /////////////////////////////////////////////////////////--}}








                    {{--//////////////////////////////////////////////////// start tue table /////////////////////////////////////////////////////////--}}
                     @include('back.time_table_ramadan_month.days.tue')
                    {{--//////////////////////////////////////////////////// end tue table /////////////////////////////////////////////////////////--}}








                    {{--//////////////////////////////////////////////////// start wed table /////////////////////////////////////////////////////////--}}
                     @include('back.time_table_ramadan_month.days.wed')
                    {{--//////////////////////////////////////////////////// end wed table /////////////////////////////////////////////////////////--}}








                    {{--//////////////////////////////////////////////////// start thu table /////////////////////////////////////////////////////////--}}
                     @include('back.time_table_ramadan_month.days.thu')
                    {{--//////////////////////////////////////////////////// end  thu table /////////////////////////////////////////////////////////--}}








                    {{--//////////////////////////////////////////////////// start fri table /////////////////////////////////////////////////////////--}}
                     @include('back.time_table_ramadan_month.days.fri')
                    {{--//////////////////////////////////////////////////// end fri table /////////////////////////////////////////////////////////--}}


                </div>
            </div>
        </div>


    </div>
@endsection

