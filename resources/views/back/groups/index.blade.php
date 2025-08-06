
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

        @media (min-width: 992px) {
            #exampleModalCenter .modal-xl {
                width: 90%; 
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

        // close sidebar when page reload
        $("body").addClass('sidenav-toggled');

        // selectize
        $('.selectize').selectize();



        // focus any input type = number
        $(document).on('focus', '#modalStudents input[type=number]', function() {
            $(this).select();
        });



        // flatpickr
        flatpickr(".datePicker");
        

        // remove all errors and inputs data when close modal
        $('.modal').on('hidden.bs.modal', function(){
            $('form [id^=errors]').text('');
        });
        


        // remove all values when click .add button
        //$('.add').on('click', function(){
        //    $('.dataInput').val('');

        //    $('#TheYear, #TheMat', '#LangType').each(function() {
        //        $(this)[0].selectize.clear();
        //    });
        //});

        // cancel enter button 
        $(document).keypress(function (e) {
            if(e.which == 13){
                e.preventDefault();  
            }
        });



        // when change YearID
        $("#YearID").on('input', function(){
            const thisVal = $(this).val();

            $.ajax({
                type: 'get',
                beforeSend: function(){
                    $('#TeacherID')[0].selectize.clearOptions();
                },
                url: `{{ url('getByAjax/get_teachers_by_years_mat') }}/${thisVal}`,
                success: function(res){
                    if(res.teachers.length > 0){
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.success("تم استدعاء المدرسين بنجاح");
                        
                        $.each(res.teachers, function(index, value){
                            $('#TeacherID')[0].selectize.addOption({
                                value: value.teacherId,
                                text: value.teacherName
                            });
                        });
                    }else{
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.error("لا يوجد مدرسين مرتبطين بهذه المادة في الوقت الحالي");
                    }
                }
            });
        });
        
        

        // when change TeacherID
        $("#TeacherID").on('input', function(){
            const thisVal = $(this).val();

            $.ajax({
                type: 'get',
                beforeSend: function(){
                    $("#GroupStaticValue").val('');
                },
                url: `{{ url('getByAjax/get_teacher_accounting_type') }}/${thisVal}`,
                success: function(res){
                    if(res.teacher){
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.success("تم استدعاء طرق حساب المدرس بنجاح");
                        
                        $("#GroupStaticValue").val(res.teacher.static_value);
                    }

                    if(res.teacher_error){
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.error("هذا المدرس لم تقم بإضافة طرق حساب له");
                    }
                }
            });
        });
        // when change TeacherID


        // when change GroupTeacherPayType قيمة ثابتة او نسبة
        $("#GroupTeacherPayType").on('input', function () {
            const show = $(this).val() === 'قيمة ثابتة';
            const display = show ? 'block' : 'none';
            
            $("#GroupStaticValueSection, #GroupExtraValueSection, #GroupMiniStudentsSection").css('display', display);
        });
        // when change GroupTeacherPayType قيمة ثابتة او نسبة


        



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
        $(document).on('click', '#modalStudents table tbody .student_td', function(){
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
                        {data: 'GroupName', name: 'GroupName'},
                        {data: 'OpenDate', name: 'OpenDate'},
                        {data: 'TheFullNameSubject', name: 'YearID'},
                        {data: 'ClassType', name: 'ClassType'}, // نوع الحصة
                        {data: 'TeacherName', name: 'TeacherName'}, // المدرس
                        {data: 'LangName', name: 'TheLangID'}, // نظام التعليم
                        {data: 'TheTestType', name: 'TheTestType'}, // نوع الإختبارات
                        {data: 'ClassNo1', name: 'ClassNo1'}, // حصص متوقعه
                        {data: 'classesCompleted', name: 'classesCompleted'}, // حصص تمت
                        {data: 'ThePrice', name: 'ThePrice'}, //  السعر
                        {data: 'TheStatus', name: 'TheStatus'},
                        {data: 'CloseDate', name: 'CloseDate'},
                        {data: 'TheNotes', name: 'TheNotes'},
                        {data: 'GroupTeacherPayType', name: 'GroupTeacherPayType'},
                        {data: 'GroupStaticValue', name: 'GroupStaticValue'},
                        {data: 'GroupExtraValue', name: 'GroupExtraValue'},
                        {data: 'GroupMiniStudents', name: 'GroupMiniStudents'},
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
                    "bDestroy": true,
                    "order": [[ 0, "desc" ]],
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
        // end DataTable
    </script>

    {{-- add, edit, delete => script --}}
    @include('back.groups.add')
    @include('back.groups.edit')
    @include('back.groups.delete')
    @include('back.groups.show_students_js')
    @include('back.groups.save_students_js')
    @include('back.groups.remove_all_or_one_student_js')
    @include('back.groups.close_group_js')

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
        
        @include('back.groups.form')
        @include('back.groups.edit_form')
        @include('back.groups.close_group_form')
        @include('back.groups.modalStudents')

        <div class="card">
            <div class="card-body">
                <div class="">
                    <table class="table table-responsive table-bordered table-striped table-hover text-center text-md-nowrap" id="example1">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border-bottom-0 nowrap_thead">#</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 150px !important;min-width: 150px !important;">التحكم</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 100px !important;min-width: 100px !important;">إسم المجموعة</th>
                                <th class="border-bottom-0 nowrap_thead">تاريخ الإضافة</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 150px !important;min-width: 150px !important;">الصف والمادة</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 90px !important;min-width: 90px !important;">نوع الحصة</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 100px !important;min-width: 100px !important;">المدرس</th>
                                <th class="border-bottom-0 nowrap_thead">نظام التعليم</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 90px !important;min-width: 90px !important;">نظام الإختبارات</th>
                                <th class="border-bottom-0 nowrap_thead">حصص متوقعة</th>
                                <th class="border-bottom-0 nowrap_thead">حصص تمت</th>
                                <th class="border-bottom-0 nowrap_thead">السعر</th>
                                <th class="border-bottom-0 nowrap_thead">الحالة</th>
                                <th class="border-bottom-0 nowrap_thead">تاريخ الإغلاق</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 90px !important;min-width: 90px !important;">ملاحظات</th>
                                <th class="border-bottom-0 nowrap_thead">نسبة/قيمة</th>
                                <th class="border-bottom-0 nowrap_thead">القيمة الثابتة</th>
                                <th class="border-bottom-0 nowrap_thead">الحد الأدني للطلاب</th>
                                <th class="border-bottom-0 nowrap_thead">قيمة الإكسترا</th>
                                <th class="border-bottom-0 nowrap_thead">السنة</th>
                            </tr>
                        </thead>                                
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

