
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
        let session_id = @json($sessionId);
        let group_id = @json($groupId);

        // cancel enter button 
        $(document).keypress(function (e) {
            if(e.which == 13){
                e.preventDefault();  
            }
        });
        
        $(document).ready(function () {
    // إعداد CSRF مرة واحدة فقط في الأعلى
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ url($pageNameEn) }}/datatable/{{ $groupId }}/{{ $sessionId }}`,
                dataType: 'json',
                columns: [
                    {data: 'delete', name: 'delete'},
                    {data: 'StudentID', name: 'StudentID'},
                    {data: 'studentName', name: 'studentName'},
                    {data: 'studentStatus', name: 'studentStatus', orderable: false},
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
                order: [[ 2, "asc" ]],
                paging: false,          
                pageLength: -1,
                lengthChange: false,
                info: false,
                language: { sUrl: '{{ asset("back/assets/js/ar_dt.json") }}' }
            });

        });


        // start count طلاب حاضرين \ طلاب غائبين
        function countStudentsStatus() {
            let present = 0;
            let absent = 0;

            $('.studentStatus').each(function () {
                const value = $(this).val();
                
                if (value === 'حاضر') {
                    present++;
                } else if (value === 'غائب/مدفوع') {
                    present++;
                } else if (value === 'غائب') {
                    absent++;
                }
            });

            $('#present_students strong').text(`${present}`);
            $('#absent_students strong').text(`${absent}`);
        }
        // end count طلاب حاضرين \ طلاب غائبين


        // start when change change_status parent apply to child
        $(document).on('input', '#change_status', function(){
            const thisVal = $(this).val();

            $('.studentStatus').each(function() {
                $(this).val(thisVal);
            });

            countStudentsStatus();

            alertify.set('notifier','position', 'top-center');
            alertify.set('notifier','delay', 3);
            alertify.success(`✅ تم تعيين كل الطلاب كـ "${thisVal}" 👨‍🏫👩‍🎓`);
        });
        // end when change change_status parent apply to child

        

        // when change studentStatus
        $(document).on('input', '.studentStatus', function(){
            countStudentsStatus();
        });



        // start when click closeCheck اغلاق ةتاكيد تفقد الحصه
        $("#closeCheck, #openCheck").on("click", function(){

            alertify.confirm(
                'انتبة !! <i class="fas fa-exclamation-triangle text-warning" style="margin: 0px 3px;"></i>',
                `<div style="text-align: center;">
                    <p style="font-weight: bold;">
                        ⚠️ هل أنت متأكد من تغيير حالة الحصة؟ 🔄
                        <p>📌 يرجى التأكد قبل المتابعة.</p>
                    </p>
                </div>`,
            function(){
                $("#overlay_page").show();
                $.ajax({
                    url: `{{ url($pageNameEn) }}/close_open_session/${session_id}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res){
                        location.reload();
                        
                        $("#overlay_page").hide();
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 4);
                        alertify.success(`${res.success}`);
                    }
                });

            }, function(){

            }).set({
                labels:{
                    ok:"نعم <i class='fas fa-check text-success' style='margin: 0px 3px;'></i>",
                    cancel: "لاء <i class='fa fa-times text-light' style='margin: 0px 3px;'></i>"
                }
            });
        });
        // end when click closeCheck اغلاق ةتاكيد تفقد الحصه



        // start when click attendanceForm 
        $("#attendanceForm").submit(function(e){
            e.preventDefault();

            let hasEmpty = false;

            $('.studentStatus').each(function(){
                if ($(this).val() === null || $(this).val() === '') {
                    hasEmpty = true;
                }
            });


            if( hasEmpty == true){
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 4);
                alertify.error(" يجب تحديد حالة الحضور لكل طالب قبل حفظ التفقد ❌⚠️");

                return;

            }else {
                alertify.confirm(
                    'انتبة !! <i class="fas fa-exclamation-triangle text-warning" style="margin: 0px 3px;"></i>',
                    `<div style="text-align: center;">
                        <p style="font-weight: bold;">هل أنت متأكد من حفظ التفقد للحصة المحددة؟ 📋✅</p>
                        <p style="color: #007bff;">
                            سيتم حفظ حالات الحضور والغياب للطلاب بناءً على اختياراتك الحالية.
                        </p>
                    </div>`,

                function(){
                    $.ajax({
                        url: `{{ url($pageNameEn) }}/store/${group_id}/${session_id}`,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: new FormData($('#attendanceForm')[0]),
                        beforeSend: function() {
                            $("#overlay_page").show();
                        },
                        success: function(res){
                            alertify.set('notifier','position', 'top-center');
                            alertify.set('notifier','delay', 4);
                            alertify.success("✅ تم حفظ تفقد الحصة بنجاح 📝🎯");

                            location.reload();
                            $("#overlay_page").hide();
                        }
                    });
                }, function(){

                }).set({
                    labels:{
                        ok:"نعم <i class='fas fa-check text-success' style='margin: 0px 3px;'></i>",
                        cancel: "لاء <i class='fa fa-times text-light' style='margin: 0px 3px;'></i>"
                    }
                });
            }
            
        });
        // end when click attendanceForm 

        

        // start when click to button delete in datatable => remove thisRow
        $(document).on('click', '.delete', function(){
            let countTr = $('#example1 tbody tr').length;
            if (countTr <= 1) {
                countStudentsStatus();

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 4);
                alertify.error("❌ لا يمكن حذف الطالب، يجب أن يبقى طالب واحد على الأقل في العرض الحالي.");
                return;
            } else {
                $(this).closest('tr').remove();
                countStudentsStatus();

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 4);
                alertify.success("👤❌ تم حذف الطالب من العرض الحالي فقط ✅");
            }
        });
        // end when click to button delete in datatable => remove thisRow

    </script>

    {{-- add, edit, delete => script --}}
    @include('back.groups_sessions.add')
@endsection



@section('content')
    <div class="container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">
                        {{ $pageNameAr }} 
                        مجموعة <span class="badge badge-info-transparent">( رقم {{ $groupInfo->ID }} ) {{ $groupInfo->GroupName }}</span>                            
                        حصة <span class="badge {{ $sessionInfo->TheStatus == 'غير مؤكد' ? 'badge-danger-transparent' : 'badge-success-transparent' }} ">( رقم {{ $sessionInfo->ClassNumber }} ) {{ $sessionInfo->TheDate }} - {{ $sessionInfo->TheStatus }}</span>                            
                    </h4>    
                </div>

                <div style="display: flex; gap: 20px; justify-content: center; align-items: center; margin-top: 20px; flex-wrap: wrap;">
                    <div id="total_students" class="badge bg-primary-transparent d-flex align-items-center px-3 py-2 rounded-pill" style="font-size: 16px;">
                        👥 <span class="ms-1">عدد الطلاب:</span> <strong class="ms-1">{{ $countStudents }}</strong>
                    </div>
    
                    <div id="present_students" class="badge bg-success-transparent d-flex align-items-center px-3 py-2 rounded-pill" style="font-size: 16px;">
                        ✅ <span class="ms-1">الحضور:</span> <strong class="ms-1">0</strong>
                    </div>
    
                    <div id="absent_students" class="badge bg-danger-transparent d-flex align-items-center px-3 py-2 rounded-pill" style="font-size: 16px;">
                        ❌ <span class="ms-1">الغياب:</span> <strong class="ms-1">0</strong>
                    </div>

                    <select id="change_status" class="bg bg-info-gradient" style="font-weight: bold;text-align: center;padding: 5px 10px; border-radius: 8px; font-size: 12px; border: 1px solid #ccc; min-width: 200px; cursor: pointer;height: 29px !important;">
                        <option selected disabled>📌  حالة الحضور للكل</option>
                        <option value="حاضر">حاضر</option>
                        <option value="غائب">غائب</option>
                        <option value="غائب/مدفوع">غائب/مدفوع</option>
                    </select>


                    @if ($sessionInfo->TheStatus == 'غير مؤكد')
                        <button id="closeCheck" style="background-color: #dc3545; color: white; padding: 5px 10px; border: none; min-width: 200px; border-radius: 8px; font-size: 12px; cursor: pointer;">
                            🔒 إغلاق وتأكيد تفقد الحصة
                        </button>                        
                    @else
                        <button id="openCheck" style="background-color: #28a745; color: white; padding: 5px 10px; border: none; min-width: 200px; border-radius: 8px; font-size: 12px; cursor: pointer;">
                            🔒 فتح تفقد الحصة
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <!-- breadcrumb -->
        <br>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <form id="attendanceForm">
                        @csrf
                        
                        <table class="table table-bordered table-striped table-hover text-center" id="example1">
                            <thead>
                                <tr>
                                    <th>حذف</th>
                                    <th style="width: 15% !important;min-width: 15% !important;">رقم الطالب</th>
                                    <th style="width: 55% !important;min-width: 55% !important;">طلاب المجموعة</th>
                                    <th style="width: 20% !important;min-width: 20% !important;">حالة الحضور</th>
                                </tr>
                            </thead>
                        </table>

                        @if ($sessionInfo->TheStatus == 'غير مؤكد')
                            <div class="text-center mt-3" style="margin-bottom: 15px !important;">
                                <button type="submit" class="btn btn-success-gradient btn-rounded" style="width: 100%;">✅ حفظ التفقد</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

