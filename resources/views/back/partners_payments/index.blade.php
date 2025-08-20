
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
        
        // start DataTable
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
                    {data: 'ID', name: 'ID'},
                    {data: 'TheDate', name: 'TheDate'},
                    {data: 'partnerName', name: 'partnerName'},
                    {data: 'TheAmount', name: 'TheAmount'},
                    {data: 'TheNotes', name: 'TheNotes'},
                    {data: 'WalletName', name: 'WalletName'},
                    {data: 'academicYearName', name: 'academicYearName'},
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
                order: [[ 1, "desc" ]],
                language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                lengthMenu: [[20, 50, 100, 200, -1], [20, 50, 100, 200, "الكل"]]
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
        // end DataTable



        $(document).ready(function () {
            // selectize
            $('.selectize').selectize();
            
    
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
                        <div>
                            <button id="search" class="btn btn-warning-gradient btn-block" style="height: 36px;font-size: 12px;font-weight: bold;">بحث</button>
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
                                <th class="border-bottom-0" style="width: 50px !important;max-width: 50px !important;">#</th>
                                <th class="border-bottom-0" style="width: 80px !important;max-width: 80px !important;">تاريخ العملية</th>
                                <th class="border-bottom-0" style="width: 100px !important;max-width: 100px !important;">الشريك</th>
                                <th class="border-bottom-0" style="width: 70px !important;max-width: 70px !important;">المبلغ</th>
                                <th class="border-bottom-0" style="width: 200px !important;max-width: 200px !important;">ملاحظات</th>
                                <th class="border-bottom-0" style="width: 100px !important;max-width: 100px !important;">المحفظة</th>
                                <th class="border-bottom-0" style="width: 100px !important;max-width: 100px !important;">السنة الأكاديمية</th>
                            </tr>
                        </thead>                                
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

