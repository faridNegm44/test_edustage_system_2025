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

        // flatpickr
        flatpickr(".datePicker");

        // cancel enter button 
        $(document).keypress(function (e) {
            if(e.which == 13){
                e.preventDefault();  
            }
        });


        // start DataTable
        $(document).ready(function () {
            let table;

            $('#search').on('click', function (e) {
                const from = $('#from').val();
                const to = $('#to').val();
                if(!from || !to){
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 4);
                    alertify.error('⚠️ حدد تاريخ البداية 📅 والنهاية قبل عرض التقرير 📄');
    
                    return false;
                }else{
                    e.preventDefault();
                    $("#overlay_page").show();
                    
                    table = $('#example1').DataTable({
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
                            {data: 'groupId', name: 'groupId'},
                            {data: 'groupName', name: 'groupName', orderable: false},
                            {data: 'teacherName', name: 'teacherName'},
                            {data: 'ClassNo1', name: 'ClassNo1'},
                            {data: 'totalClasses', name: 'totalClasses'},
                            {data: 'percentage', name: 'percentage'},
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

                    $('#example1').on('xhr.dt', function () {
                        $('#overlay_page').hide();
                    });
                }
            });
        });

        // end DataTable
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
        
        <div class="card">
            <div class="card-body">
                <div class="table-container" style="width: 100% !important;max-width: 100% !important;overflow: auto;">
                    <table class="table table-bordered table-striped table-hover text-center text-md-nowrap" id="example1" style="max-height: 70vh; overflow: auto;">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border-bottom-0 nowrap_thead">#</th>
                                <th class="border-bottom-0 nowrap_thead">المجموعة</th>
                                <th class="border-bottom-0 nowrap_thead">المدرس</th>                                
                                <th class="border-bottom-0 nowrap_thead">حصص متوقعة</th>
                                <th class="border-bottom-0 nowrap_thead">حصص تمت</th>
                                <th class="border-bottom-0 nowrap_thead">نسبة التنفيذ</th>
                                <th class="border-bottom-0 nowrap_thead">السنة</th>
                            </tr>
                        </thead>                      
                    </table>
                </div>
            </div>
        </div>        
    </div>
@endsection

