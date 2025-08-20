@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    <style>
        tbody td:nth-child(4),
        tbody td:nth-child(5),
        tbody td:nth-child(7) {
            text-align: right;
        }

        #example1 {
            position: relative;
        }

        #example1 thead th {
            position: sticky;
            top: 0;
            z-index: 10;
        }
    </style>
@endsection

@section('footer')  
    <script>
        flatpickr(".datePicker", {
            dateFormat: "Y-m-d", 
            time_24hr: false
        });
    </script>

    <script>
        $("body").addClass('sidenav-toggled');
        
        // start datatable to لائحه رغبات الطلاب
            $(document).ready(function () {
                let table = $('#example1').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: `{{ url($pageNameEn) }}/datatable`,
                        type: 'GET',
                        data: function (d) {
                            d.from = $('#from').val();
                            d.to = $('#to').val();
                            d.academic_year = $('#academic_year').val();
                        }
                    },
                    dataType: 'json',
                    columns: [
                        {data: 'ID', name: 'ID', render: function(data) {
                            return `<span class="">#${data}</span>`;
                        }},
                        {data: 'TheDate', name: 'TheDate', render: function(data) {
                            return `<i class="fas fa-calendar-alt text-primary" style="margin: 0 3px;"></i> ${data}`;
                        }},
                        {data: 'parentName', name: 'parentName', render: function(data) { return data; }},
                        {data: 'ThePhone1', name: 'ThePhone1', render: function(data) {
                            return `<i class="fas fa-phone text-danger"></i> ${data}`;
                        }},
                        {data: 'ThePhone2', name: 'ThePhone2', render: function(data) {
                            return `
                                <a class="ThePhone2 text-right d-block" href="https://wa.me/${data}" target="_blank" style="font-size: 12px;color: #069608 !important;">
                                    <i class="fab fa-whatsapp" style="margin: 3px;position: relative;top: 2px;"></i>
                                    ${data}
                                </a>
                            `;
                        }},
                        {data: 'studentName', name: 'studentName', render: function(data) { 
                            return `<span class="badge badge-pink" style="width: 100% !important;font-size: 120% !important;">${data}</span>`;
                        }},
                        {data: 'studentPhone', name: 'studentPhone', render: function(data) {
                            return `<i class="fas fa-phone text-danger"></i> ${data}`;
                        }},
                        {data: 'TheYear', name: 'TheYear', render: function(data) {
                            return `<span class="badge badge-primary" style="width: 80% !important;font-size: 100% !important;">${data}</span>`;
                        }},
                        {data: 'TheMat', name: 'TheMat', render: function(data) {
                            return `<span class="badge text-white" style="width: 80% !important;font-size: 110% !important;background: #2b833b !important;">${data}</span>`;
                        }},
                        {data: 'LangName', name: 'LangName', render: function(data) { return data; }},
                        {data: 'TheTestType', name: 'TheTestType', render: function(data) { return data; }},
                        {data: 'TheTime', name: 'TheTime', render: function(data) {
                            return `<i class="fas fa-clock text-danger"></i> ${data}`;
                        }},
                        {data: 'ThePackage', name: 'ThePackage', render: function(data) { return data; }},
                        {data: 'parentEmail', name: 'parentEmail', render: function(data) { return data; }},
                        {data: 'studentStatus', name: 'studentStatus', render: function(data) {
                            if (data === 'مفعل') {
                                return `<span class="badge badge-success" style="font-size:12px;"><i class="fas fa-check-circle"></i> ${data}</span>`;
                            }else if (data === 'غير مفعل') {
                                return `<span class="badge badge-danger" style="font-size:12px;"><i class="fas fa-ban"></i> ${data}</span>`;
                            }else if (data === 'جديد') {
                                return `<span class="badge badge-primary" style="font-size:12px;"><i class="fas fa-check-circle"></i> ${data}</span>`;
                            }else{
                                return `<span class="badge badge-warning" style="font-size:12px;"><i class="fas fa-exclamation-triangle"></i> ${data}</span>`;
                            }
                        }},
                        {data: 'TheNotes', name: 'TheNotes', render: function(data) {
                            if (data === null || data === '') {
                                return `<i class="fas fa-sticky-note text-muted"></i>`;
                            }
                            return data;
                        }},
                        {data: 'academicYearName', name: 'academicYearName', render: function(data) { return data; }},
                    ],
                    dom: "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        { extend: 'excel', text: '📊 Excel', className: 'btn btn-outline-dark', exportOptions: { columns: ':visible'} },
                        { extend: 'print', text: '🖨️ طباعة', className: 'btn btn-outline-dark', exportOptions: { columns: ':visible'}, customize: function (win) { $(win.document.body).css('direction', 'rtl'); } },
                        { extend: 'colvis', text: '👁️ إظهار/إخفاء الأعمدة', className: 'btn btn-outline-dark' }
                    ],
                    bDestroy: true,
                    order: [[ 0, "desc" ]],
                    language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                    lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "الكل"]]
                });

                $('#search').on('click', function (e) {
                    e.preventDefault();
                    $("#overlay_page").show();
                    table.ajax.reload();
                });

                table.on('xhr.dt', function () {
                    $('#overlay_page').hide();
                });
            });
        // end datatable to لائحه رغبات الطلاب
    </script>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">{{ $pageNameAr }}</h4>
                </div>
            </div>
        </div>
        <!-- breadcrumb -->

        <div class="card bg bg-primary">
            <div class="card-body">

                <div class="row justify-content-center">
                    <div class="col-md-2">
                        <div>
                            <select name="academic_year" class="form-control" id="academic_year">
                                <option value="" selected class="text-muted">اختر سنة أكاديمية</option>                              
                                @foreach ($academic_years as $year)
                                  <option value="{{ $year->id }}">( {{ $year->id }} ) - {{ $year->name }}</option>                              
                                @endforeach
                            </select>
                        </div>
                        <bold class="text-danger" id="errors-treasury" style="display: none;"></bold>
                    </div>   
                                    
                    <div class="col-md-2">
                        <div>
                            <input type="text" class="form-control datePicker" placeholder="من" id="from" name="from">
                        </div>
                        <bold class="text-danger" id="errors-from" style="display: none;"></bold>
                    </div>    
                    
                    <div class="col-md-2">
                        <div>
                            <input type="text" class="form-control datePicker" placeholder="الي" id="to" name="to">
                        </div>
                        <bold class="text-danger" id="errors-to" style="display: none;"></bold>
                    </div>    

                    <div class="col-md-2">
                        <div> <button id="search" class="btn btn-warning-gradient btn-block" style="height: 36px;font-size: 12px;font-weight: bold;">بحث</button> </div>
                        <bold class="text-danger" id="errors-to" style="display: none;"></bold>
                    </div>       
                    
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="table-container" >
                    <table class="table table-responsive table-bordered table-striped table-hover text-center text-md-nowrap" id="example1" style="max-height: 70vh; overflow: auto;">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border-bottom-0 nowrap_thead">#</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 90px !important;min-width: 90px !important;">تاريخ التسجيل</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 130px !important;min-width: 130px !important;">اسم ولي الأمر</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 100px !important;min-width: 100px !important;">هاتف ولي الأمر</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 100px !important;min-width: 100px !important;">واتساب ولي الأمر</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 50px !important;min-width: 50px !important;">الطالب</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 100px !important;min-width: 100px !important;">هاتف الطالب</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 110px !important;min-width: 110px !important;">الصف الدراسي/الدورة التعليمية</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 100px !important;min-width: 100px !important;">المادة</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 130px !important;min-width: 130px !important;">نظام التعليم</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 130px !important;min-width: 130px !important;">نظام الاختبارات</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 50px !important;min-width: 50px !important;">الفترة</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 70px !important;min-width: 70px !important;">الباقة</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 120px !important;min-width: 120px !important;">ايميل ولي الأمر</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 100px !important;min-width: 100px !important;">حالة الطالب</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 100px !important;min-width: 100px !important;">ملاحظات</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 90px !important;min-width: 90px !important;">السنة</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

