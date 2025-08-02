@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    <style>
        td{
            font-size: 10px !important;
            font-weight: bold;
        }

        tbody td:nth-child(7),
        tbody td:nth-child(8) {
            text-align: right;
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
                ///////////////////// get all data when page load
                $('#example1').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: `{{ url($pageNameEn.'/datatable/') }}`,
                        type: 'GET'
                    },
                    columns: [
                        {data: 'ID', name: 'ID'},
                        {data: 'StudentID', name: 'StudentID'},
                        {data: 'TheDate', name: 'TheDate'},
                        {data: 'studentName', name: 'studentName'},
                        {data: 'parentName', name: 'parentName'},
                        {data: 'ThePhone', name: 'ThePhone'},
                        {data: 'ThePhone2', name: 'ThePhone2'},
                        {data: 'TheYear', name: 'TheYear'},
                        {data: 'TheMat', name: 'TheMat'},
                        {data: 'LangName', name: 'LangName'},
                        {data: 'TheTestType', name: 'TheTestType'},
                        {data: 'TheTime', name: 'TheTime'},
                        {data: 'ThePackage', name: 'ThePackage'},
                        {data: 'TheNotes', name: 'TheNotes'},
                        {data: 'academicYearName', name: 'academicYearName'},
                    ],
                    "bDestroy": true,
                    language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                    order: [[0, "DESC"]],
                    lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "الكل"]],
                    initComplete: function(settings, json) {
                        $("#overlay_page").hide();
                    }
                });


                ///////////////////// get data when click btn search
                $("#search").on('click', function(e){
                    e.preventDefault();
                    const from = $("#from").val();
                    const to = $("#to").val();
                    const academic_year = $("#academic_year").val();
                    $("#overlay_page").show();
                                        
                    $('#example1').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: `{{ url($pageNameEn.'/datatable/') }}`,
                            type: 'GET',
                            data: function (d) {
                                d.from = from;
                                d.to = to;
                                d.academic_year = academic_year;
                            }
                        },
                        columns: [
                            {data: 'ID', name: 'ID'},
                            {data: 'StudentID', name: 'StudentID'},
                            {data: 'TheDate', name: 'TheDate'},
                            {data: 'studentName', name: 'studentName'},
                            {data: 'parentName', name: 'parentName'},
                            {data: 'ThePhone', name: 'ThePhone'},
                            {data: 'ThePhone2', name: 'ThePhone2'},
                            {data: 'LangName', name: 'LangName'},
                            {data: 'TheTestType', name: 'TheTestType'},
                            {data: 'TheYear', name: 'TheYear'},
                            {data: 'TheMat', name: 'TheMat'},
                            {data: 'TheTime', name: 'TheTime'},
                            {data: 'ThePackage', name: 'ThePackage'},
                            {data: 'TheNotes', name: 'TheNotes'},
                            {data: 'academicYearName', name: 'academicYearName'},
                        ],
                        "bDestroy": true,
                        language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                        order: [[0, "DESC"]],
                        lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "الكل"]],
                        initComplete: function(settings, json) {
                            $("#overlay_page").hide();
                        }
                    });
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

        <div class="card bg bg-warning-gradient">
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
                        <div>
                            <button id="search" class="btn btn-primary btn-block" style="height: 36px;font-size: 12px;font-weight: bold;">بحث</button>
                        </div>
                        <bold class="text-danger" id="errors-to" style="display: none;"></bold>
                    </div>    
                    
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center text-md-nowrap_thead" id="example1" style="width: 100%;">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border-bottom-0 nowrap_thead">#</th>
                                <th class="border-bottom-0 nowrap_thead">كود الطالب</th>
                                <th class="border-bottom-0 nowrap_thead">تاريخ التسجيل</th>
                                <th class="border-bottom-0 nowrap_thead">الطالب</th>
                                <th class="border-bottom-0 nowrap_thead">اسم ولي الأمر</th>
                                <th class="border-bottom-0 nowrap_thead">هاتف</th>
                                <th class="border-bottom-0 nowrap_thead">واتساب ولي الأمر</th>
                                <th class="border-bottom-0 nowrap_thead">الصف الدراسي/الدورة التعليمية</th>
                                <th class="border-bottom-0 nowrap_thead">المادة</th>
                                <th class="border-bottom-0 nowrap_thead">نظام التعليم</th>
                                <th class="border-bottom-0 nowrap_thead">نظام الاختبارات</th>
                                <th class="border-bottom-0 nowrap_thead">الفترة</th>
                                <th class="border-bottom-0 nowrap_thead">الباقة</th>
                                <th class="border-bottom-0 nowrap_thead">ملاحظات</th>
                                <th class="border-bottom-0 nowrap_thead">السنة</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

