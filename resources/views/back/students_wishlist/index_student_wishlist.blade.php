@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }} - {{ $studentInfo->TheName . ' '. $studentInfo->parentName}}
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
        // selectize
        $('.selectize').selectize();
    </script>

    <script>        
        // start datatable
        $(document).ready(function () {
            const studentId = @json($studentInfo->ID);
            
            ///////////////////// get all data when page load
            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ url($pageNameEn.'/datatable_student_wishlist/${studentId}') }}`,
                    type: 'GET'
                },
                columns: [
                    {data: 'ID', name: 'ID'},
                    {data: 'TheDate', name: 'TheDate'},
                    {data: 'TheYear', name: 'TheYear'},
                    {data: 'TheMat', name: 'TheMat'},
                    {data: 'TheTime', name: 'TheTime'},
                    {data: 'ThePackage', name: 'ThePackage'},
                    {data: 'TheNotes', name: 'TheNotes'},
                    {data: 'academicYearName', name: 'academicYearName'},
                    {data: 'action', name: 'action'},
                ],
                "bDestroy": true,
                language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                order: [[0, "asc"]],
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
                        url: `{{ url($pageNameEn.'/datatable_student_wishlist/${studentId}') }}`,
                        type: 'GET',
                        data: function (d) {
                            d.from = from;
                            d.to = to;
                            d.academic_year = academic_year;
                        }
                    },
                    columns: [
                        {data: 'ID', name: 'ID'},
                        {data: 'TheDate', name: 'TheDate'},
                        {data: 'TheYear', name: 'TheYear'},
                        {data: 'TheMat', name: 'TheMat'},
                        {data: 'TheTime', name: 'TheTime'},
                        {data: 'ThePackage', name: 'ThePackage'},
                        {data: 'TheNotes', name: 'TheNotes'},
                        {data: 'academicYearName', name: 'academicYearName'},
                        {data: 'action', name: 'action'},
                    ],
                    "bDestroy": true,
                    language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                    order: [[0, "asc"]],
                    lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "الكل"]],
                    initComplete: function(settings, json) {
                        $("#overlay_page").hide();
                    }
                });
            });
        });
        // end datatable
    </script>

    {{-- add, edit, delete => script --}}
    @include('back.students_wishlist.add')
    @include('back.students_wishlist.delete')

@endsection

@section('content')
    <div class="container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">
                        {{ $pageNameAr }}: 
                        <span class="badge badge-secondary"> {{ $studentInfo->TheName . ' '. $studentInfo->parentName}}</span>
                        كود: <span class="badge badge-secondary"> {{ $studentInfo->ID }}</span>
                    </h4>
                </div>
            </div>
            <div class="d-flex my-xl-auto right-content">
                <div class="pr-1 mb-xl-0">
                    <button type="button" class="btn btn-danger btn-icon ml-2 add" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter"><i class="mdi mdi-plus"></i></button>
                </div>
            </div>
        </div>
        <!-- breadcrumb -->

        @include('back.students_wishlist.form')

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
                    <table class="table table-bordered table-striped table-hover text-center text-md-nowrap" id="example1">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0 nowrap_thead">تاريخ التسجيل</th>
                                <th class="border-bottom-0 nowrap_thead">الصف الدراسي/الدورة التعليمية</th>
                                <th class="border-bottom-0 nowrap_thead">المادة</th>
                                <th class="border-bottom-0 nowrap_thead">الفترة</th>
                                <th class="border-bottom-0 nowrap_thead">الباقة</th>
                                <th class="border-bottom-0 nowrap_thead">ملاحظات</th>
                                <th class="border-bottom-0 nowrap_thead">السنة</th>
                                <th class="border-bottom-0">التحكم</th>
                            </tr>
                        </thead>                                
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

