
@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    <style>
        .flatpickr-am-pm{
            display: none !important;
        }
    </style>
@endsection

@section('footer')
    <script>
        flatpickr(".datePicker");

        //let datePickerInstance;
        //$('.modal').on('shown.bs.modal', function () {
        //    if (!datePickerInstance) {
        //        datePickerInstance = flatpickr(".datePicker", {
        //            dateFormat: "Y-m-d",    
        //            defaultDate: new Date()
        //        });
        //    }
        //});
    </script>

    <script>     
        // open modal when click button (insert)
        document.addEventListener('keydown', function(event){
            if( event.which === 45 ){
                $('.modal').modal('show');
                document.querySelector('.modal .modal-header .modal-title').innerText = 'إضافة';
                document.querySelector('.modal .modal-footer #save').setAttribute('style', 'display: inline;');
                document.querySelector('.modal .modal-footer #update').setAttribute('style', 'display: none;');
                $('.dataInput').val('');
            }
        });

        
        // remove all errors and inputs data when close modal
        $('.modal').on('hidden.bs.modal', function(){
            $('form [id^=errors]').text('');
        });
        

        // cancel enter button 
        $(document).keypress(function (e) {
            if(e.which == 13){
                e.preventDefault();  
            }
        });
        
        $(document).ready(function () {
            // selectize
            $('.selectize').selectize();
            
            // datatable
            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ url($pageNameEn) }}/datatable`,
                dataType: 'json',
                columns: [
                    {data: 'ID', name: 'ID'},
                    {data: 'TheDate', name: 'TheDate'},
                    {data: 'partnerName', name: 'partnerName'},
                    {data: 'TheAmount', name: 'TheAmount'},
                    {data: 'TheNotes', name: 'TheNotes'},
                    {data: 'WalletName', name: 'WalletName'},
                    {data: 'academicYearName', name: 'academicYearName'},
                ],
                "bDestroy": true,
                "order": [[ 0, "desc" ]],
                language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "الكل"]]
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
                        url: `{{ url($pageNameEn) }}/datatable`,
                        type: 'GET',
                        data: function (d) {
                            d.from = from;
                            d.to = to;
                            d.academic_year = academic_year;
                        }
                    },
                    dataType: 'json',
                    columns: [
                        {data: 'ID', name: 'ID'},
                        {data: 'TheDate', name: 'TheDate'},
                        {data: 'partnerName', name: 'partnerName'},
                        {data: 'TheAmount', name: 'TheAmount'},
                        {data: 'TheNotes', name: 'TheNotes'},
                        {data: 'WalletName', name: 'WalletName'},
                        {data: 'academicYearName', name: 'academicYearName'},
                    ],
                    "bDestroy": true,
                    "order": [[ 0, "desc" ]],
                    language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                    lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "الكل"]],
                    initComplete: function(settings, json) {
                        $("#overlay_page").hide();
                    }
                });
            });
        });
    </script>

    {{-- add, edit, delete => script --}}
    @include('back.partners_payments.add')
    @include('back.partners_payments.edit')
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

        @include('back.partners_payments.form')

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-center text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">تاريخ العملية</th>
                                <th class="border-bottom-0">الشريك</th>
                                <th class="border-bottom-0">المبلغ</th>
                                <th class="border-bottom-0">ملاحظات</th>
                                <th class="border-bottom-0">المحفظة</th>
                                <th class="border-bottom-0">السنة الأكاديمية</th>
                            </tr>
                        </thead>                                
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

