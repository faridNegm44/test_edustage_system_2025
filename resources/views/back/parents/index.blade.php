@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    <style>
        .crm_categories{
            padding: 10px;
            border: 1px dotted #9d9d9d;
            border-radius: 4px;
            width: 30%;
            margin: 30px auto;
            box-shadow: 10px 7px 23px -8px rgb(151 156 209);
        }

        .categName{
            border: 1px dotted;
            width: 35%;
            padding: 10px;
            margin: 10px auto 20px;
            box-shadow: 7px 7px 5px 0px rgb(182 182 182 / 75%);
            font-weight: bold;text-align: center;
            background: linear-gradient(135deg, hsla(0, 0%, 69%, 1) 0%, hsla(227, 50%, 47%, 1) 51%);
            color: #FFF !important;

        }
        @media (min-width: 1200px) {
            .modal-xl {
                max-width: 95%;
            }
        }
        textarea{
            box-shadow: 10px 7px 23px -8px rgb(151 156 209);
        }
        
        .modal textarea{
            box-shadow: none;
        }

        td{
            font-size: 10px !important;
            font-weight: bold;
        }

        tbody td:nth-child(7),
        tbody td:nth-child(8) {
            text-align: right;
        }

        .ThePhone1, .ThePhone2{
            font-weight: bold;
            font-size: 11px;
        }
        @media (min-width: 992px) {
            #exampleModalCenter .modal-xl {
                width: 80%; 
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            #exampleModalCenter .modal-xl {
                width: 100%;
            }
        }
    </style>
@endsection

@section('footer')  
    <script>
        $("body").addClass('sidenav-toggled');



        // selectize
        $('.selectize').selectize();




        // flatpickr
        flatpickr(".datePicker");


        // remove all errors and inputs data when close modal
        $('.modal').on('hidden.bs.modal', function(){
            $('form [id^=errors]').text('');
            $(this).find("input").not("[name='_token']").val('');
            document.querySelector("#image_preview_form").src = `{{ url('back/images/parents/df_image.png') }}`;
        });
        
        


        // remove all values when click .add button
        $('.add').on('click', function(){
            $('.dataInput').val('');

            $('#NatID, #CityID').each(function() {
                $(this)[0].selectize.clear();
            });
        });



        // datatable
        $(document).ready(function () {
            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ url($pageNameEn.'/datatable') }}`,
                dataType: 'json',
                columns: [
                    {data: 'action', name: 'action', orderable: false},
                    {data: 'TheName0', name: 'TheName0'},
                    {data: 'ID', name: 'ID'},
                    {data: 'TheDate1', name: 'TheDate1'},
                    {data: 'nat_city', name: 'nat_city'},
                    {data: 'TheEmail', name: 'TheEmail'},
                    {data: 'phones', name: 'phones'},
                    {data: 'whats', name: 'whats'},
                    {data: 'academicYearName', name: 'academicYearName'},
                    {data: 'TheNotes', name: 'TheNotes'},
                    {data: 'TheStatus', name: 'TheStatus'},
                ],
                "bDestroy": true,
                "order": [[ 2, "desc" ]],
                language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "الكل"]]
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
                        url: `{{ url($pageNameEn.'/datatable') }}`,
                        type: 'GET',
                        data: function (d) {
                            d.from = from;
                            d.to = to;
                            d.academic_year = academic_year;
                        }
                    },
                    columns: [
                        {data: 'action', name: 'action', orderable: false},
                        {data: 'TheName0', name: 'TheName0'},
                        {data: 'ID', name: 'ID'},
                        {data: 'TheDate1', name: 'TheDate1'},
                        {data: 'nat_city', name: 'nat_city'},
                        {data: 'TheEmail', name: 'TheEmail'},
                        {data: 'phones', name: 'phones'},
                        {data: 'whats', name: 'whats'},
                        {data: 'academicYearName', name: 'academicYearName'},
                        {data: 'TheNotes', name: 'TheNotes'},
                        {data: 'TheStatus', name: 'TheStatus'},
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
    </script>



    {{-- add, edit, delete => script --}}
    @include('back.parents.add')
    @include('back.parents.edit')
    @include('back.parents.delete')
    @include('back.parents.crm_info')


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
            <div class="d-flex my-xl-auto right-content">
                <div class="pr-1 mb-xl-0">
                    <button type="button" class="btn btn-danger btn-icon ml-2 add" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter"><i class="mdi mdi-plus"></i></button>
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
        
        @include('back.parents.form')
        @include('back.parents.crm_form')

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center text-md-nowrap" id="example1" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 nowrap_thead" style="width: 110px !important;min-width: 110px !important;">التحكم</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 100px !important;min-width: 100px !important;">الإسم</th>
                                <th class="border-bottom-0 nowrap_thead">كود</th>
                                <th class="border-bottom-0 nowrap_thead">التاريخ</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 80px !important;min-width: 80px !important;"> الإقامة</th>
                                <th class="border-bottom-0 nowrap_thead">الإيميل</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 80px !important;min-width: 80px !important;">موبايل</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 80px !important;min-width: 80px !important;">واتساب</th>
                                <th class="border-bottom-0 nowrap_thead">السنة</th>
                                <th class="border-bottom-0 nowrap_thead">ملاحظات</th>
                                <th class="border-bottom-0 nowrap_thead">الحالة</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

