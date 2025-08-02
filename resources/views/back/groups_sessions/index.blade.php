
@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }} ( {{ $groupInfo->ID }} ) {{ $groupInfo->GroupName }}
@endsection

@section('header')
    <style>
        .flatpickr-am-pm{
            display: none !important;
        }
        
        .ajs-success{
            min-width: 350px !important;
        }
        .ajs-error{
            min-width: 350px !important;
        }

        #takeAttendance .form-group{
            margin-bottom: 0rem !important;
        }
        
        #takeAttendance table tbody td{
            padding: 3px 10px 0 !important;
        }
        #takeAttendance table tbody input{
            height: 23px !important;
        }
        #takeAttendance table input[type=checkbox]{
            height: 22px !important;
            width: 20px;
        }
        
        #takeAttendance #left{
            height: 400px !important;
            max-height: 400px !important;
            overflow: auto;
        }
        
        #takeAttendance select{
            height: 28px !important;
        }

        table tbody tr{
            cursor: pointer;
        }

    </style>
@endsection

@section('footer')
    <script>
        flatpickr(".datePicker", {
            dateFormat: "d-m-Y",
            defaultDate: new Date()
        });
    </script>

    <script>
        let datePickerInstance;
    
        $('.modal').on('shown.bs.modal', function () {
            if (!datePickerInstance) {
                datePickerInstance = flatpickr(".datePicker", {
                    dateFormat: "Y-m-d",    
                    defaultDate: new Date()
                });
            }
        });
    </script>
    
    <script>     

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

            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ url($pageNameEn) }}/datatable/{{ $id }}`,
                dataType: 'json',
                columns: [
                    {data: 'ID', name: 'ID'},
                    {data: 'ClassNumber', name: 'ClassNumber'},
                    {data: 'TheDate', name: 'TheDate'},
                    {data: 'TheStatus', name: 'TheStatus'},
                    {data: 'academicYearName', name: 'academicYearName'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                dom: "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
                    { extend: 'excel', text: '📊 Excel', className: 'btn btn-outline-dark', exportOptions: { columns: ':visible'} },
                    { extend: 'print', text: '🖨️ طباعة', className: 'btn btn-outline-dark', exportOptions: { columns: ':visible'}, customize: function (win) { $(win.document.body).css('direction', 'rtl'); } },
                    { extend: 'colvis', text: '👁️ إظهار/إخفاء الأعمدة', className: 'btn btn-outline-dark' }
                ],
                "bDestroy": true,
                //"order": [[ 0, "desc" ]],
                language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "الكل"]]
            });
        });


        // when check all in modal show students
        $(document).ready(function() {
            $('.check_all').on('click', function() {
                $('.check_item').prop('checked', $(this).prop('checked'));
            });

            $('.check_item').on('click', function() {
                var allChecked = true;
                $('.check_item').each(function() {
                if (!$(this).prop('checked')) {
                    allChecked = false;
                    return false;
                }
                });
                $('.check_all').prop('checked', allChecked);
            });
        });



        // when click to student name in table ckeck this checkbox
                $(document).on('click', '#takeAttendance table tbody .student_td', function(){
                    $(this).closest('tr').find('.check_item').prop('checked', !$(this).closest('tr').find('.check_item').prop('checked'));
                });



        // when change student_discount_top and write this in student_discount_table
                $(document).on('input', '#student_discount_top', function(){
                    const thisVal = $(this);
                    if(thisVal.val() > 100){
                        thisVal.val(0);
                        $('.student_discount_table').val(0);
                        
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.error("خصم الطالب أكبر من 100 %");
                        
                    }else{
                        $('.student_discount_table').val(thisVal.val());
                    }
                });



    </script>

    {{-- add, edit, delete => script --}}
    @include('back.groups_sessions.add')
    @include('back.groups_sessions.edit')
    @include('back.groups_sessions.delete')
    @include('back.groups_sessions.takeAttendance_js')
@endsection



@section('content')
    <div class="container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">
                        {{ $pageNameAr }}
                        <span class="badge badge-info-transparent">( {{ $groupInfo->ID }} ) {{ $groupInfo->GroupName }}</span>                            
                        @if ($groupInfo->TheStatus != 'مغلقة')
                            <span class="badge badge-success">{{ $groupInfo->TheStatus }}</span>                            
                        @else                            
                            <span class="badge badge-danger">{{ $groupInfo->TheStatus }}</span>
                        @endif
                    </h4>
                </div>
            </div>
            @if ($groupInfo->TheStatus != 'مغلقة')
                <div class="d-flex my-xl-auto right-content">
                    <div class="pr-1 mb-xl-0">
                        <button type="button" class="btn btn-danger btn-icon ml-2 add" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter"><i class="mdi mdi-plus"></i></button>
                    </div>
                </div>
            @endif
        </div>
        <!-- breadcrumb -->

        @include('back.groups_sessions.form')
        @include('back.groups_sessions.takeAttendance')

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-center text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">رقم الحصة</th>
                                <th class="border-bottom-0">تاريخ الحصة</th>
                                <th class="border-bottom-0">حالة الحصة</th>
                                <th class="border-bottom-0">السنة</th>
                                <th class="border-bottom-0">التحكم</th>
                            </tr>
                        </thead>                                
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

