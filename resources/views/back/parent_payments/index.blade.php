
@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    <style>
        .ajs-success{
            min-width: 450px !important;
        }
        .ajs-error{
            min-width: 450px !important;
        }

        #modalStudents .form-group{
            margin-bottom: 0rem !important;
        }
        
        #modalStudents table tbody td{
            padding: 3px 10px 0 !important;
        }
        #modalStudents table tbody input{
            height: 23px !important;
        }
        #modalStudents table input[type=checkbox]{
            height: 22px !important;
            width: 20px;
        }
        
        #modalStudents #left{
            height: 400px !important;
            max-height: 400px !important;
            overflow: auto;
        }

        table tbody tr{
            cursor: pointer;
        }

        #GroupStaticValueSection, #GroupExtraValueSection, #GroupMiniStudentsSection, #TeacherPercentageValueSection, #TeacherTaxValueSection{
            display: none;
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


        /* تثبيت رأس الجدول بدون شريط تمرير */
        .dataTables_scroll {
            overflow: visible !important;
        }

        .dataTables_scrollBody {
            overflow: visible !important;
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

        // close sidebar when page reload
        $("body").addClass('sidenav-toggled');

        // selectize
        $('.selectize').selectize();

        // flatpickr
        flatpickr(".datePicker");
        
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


        // show/hide gift input
        $(document).on('input', '#hasGift', function () {
            if ($(this).val() == 'نعم' ) {
                $('#giftSection').show();
                $('#gift').prop('required', true);
                
            } else if ($(this).val() == 'لاء') {
                $('#giftSection').hide();
                $('#gift').val(0);
                $('#gift').prop('required', false);
            }
        });
        // show/hide group static value section



        // start when change currency
        $(document).on('change', '#currency', function () {
            let currency = $(this).val();
            if (currency == 'جنية مصري') {
                $('#expense_price').attr('readonly', true).val(1);
                
            } else {
                $('#expense_price').attr('readonly', false).val(1);
            }
        });
        // end when change currency


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
                    {data: 'action', name: 'action', orderable: false},
                    {data: 'TheDate', name: 'TheDate'},
                    {data: 'TheName0', name: 'TheName0'},
                    {data: 'TheAmount', name: 'TheAmount'},
                    {data: 'expense_price', name: 'expense_price'},
                    {data: 'transfer_expense', name: 'transfer_expense'},
                    {data: 'amount_by_currency', name: 'amount_by_currency'},
                    {data: 'ThePayType', name: 'ThePayType'},
                    {data: 'currency', name: 'currency'},
                    {data: 'image', name: 'image'},
                    {data: 'invoice_number', name: 'invoice_number'},
                    {data: 'sender_name', name: 'sender_name'},
                    {data: 'TheNotes', name: 'TheNotes'},
                    {data: 'admin_notes', name: 'admin_notes'},
                    {data: 'status', name: 'status'},
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
                order: [[ 0, "desc" ]],
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
    </script>

    {{-- add, edit, delete => script --}}
    @include('back.parent_payments.add')
    @include('back.parent_payments.edit')
    @include('back.parent_payments.delete')

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
                    <div class="col-md-2" style="margin-bottom: 5px !important;">
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
                                    
                    <div class="col-md-2" style="margin-bottom: 5px !important;">
                        <div> <input type="text" class="form-control datePicker" placeholder="من" id="from" name="from"> </div>
                        <bold class="text-danger" id="errors-from" style="display: none;"></bold>
                    </div>    
                    
                    <div class="col-md-2" style="margin-bottom: 5px !important;">
                        <div> <input type="text" class="form-control datePicker" placeholder="الي" id="to" name="to"> </div>
                        <bold class="text-danger" id="errors-to" style="display: none;"></bold>
                    </div>    

                    <div class="col-md-2">
                        <div> <button id="search" class="btn btn-warning-gradient btn-block" style="height: 36px;font-size: 12px;font-weight: bold;">بحث</button> </div>
                        <bold class="text-danger" id="errors-to" style="display: none;"></bold>
                    </div>    
                    
                </div>
            </div>
        </div>
        
        @include('back.parent_payments.form')

        <div class="card">
            <div class="card-body">
                <div class="table-container" >
                    <table class="table table-responsive table-bordered table-striped table-hover text-center text-md-nowrap" id="example1" style="max-height: 70vh; overflow: auto;">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border-bottom-0 nowrap_thead">#</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 70px !important;min-width: 70px !important;">التحكم</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 120px !important;min-width: 120px !important;">تاريخ الدفعة</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 150px !important;min-width: 150px !important;">ولي الأمر</th>                                
                                <th class="border-bottom-0 nowrap_thead" style="width: 70px !important;min-width: 70px !important;">المبلغ</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 70px !important;min-width: 70px !important;">سعر الصرف</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 70px !important;min-width: 70px !important;">مصاريف التحويل</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 80px !important;min-width: 80px !important;">المبلغ النهائي</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 150px !important;min-width: 150px !important;">طريقة الدفع</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 90px !important;min-width: 90px !important;">العملة</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 80px !important;min-width: 80px !important;">ملف الإثبات</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 80px !important;min-width: 80px !important;">رقم الوصل</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 120px !important;min-width: 120px !important;">المرسل</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 120px !important;min-width: 120px !important;">ملاحظات ولي الأمر</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 180px !important;min-width: 180px !important;">ملاحظات الإدارة</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 90px !important;min-width: 90px !important;">الحالة</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 90px !important;min-width: 90px !important;">المحغظة</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 90px !important;min-width: 90px !important;">السنة</th>
                            </tr>
                        </thead>                      
                    </table>
                </div>
            </div>
        </div>        
    </div>
@endsection

