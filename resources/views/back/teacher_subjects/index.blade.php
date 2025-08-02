@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }} - {{ $teacherInfo->TheName }}
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
            const teacherId = @json($teacherInfo->ID);
            
            ///////////////////// get all data when page load
            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ url($pageNameEn.'/datatable/${teacherId}') }}`,
                    type: 'GET'
                },
                columns: [
                    {data: 'ID', name: 'ID'},
                    {data: 'TheYear', name: 'TheYear'},
                    {data: 'TheMat', name: 'TheMat'},
                    {data: 'academicYearName', name: 'academicYearName'},
                    {data: 'action', name: 'action'},
                ],
                "bDestroy": true,
                language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                order: [[0, "desc"]],
                lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "الكل"]]
            });
        });
        // end datatable
    </script>

    {{-- add, edit, delete => script --}}
    @include('back.teacher_subjects.add')
    @include('back.teacher_subjects.delete')

@endsection

@section('content')
    <div class="container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">
                        {{ $pageNameAr }}: 
                        <span class="badge badge-danger"> {{ $teacherInfo->TheName }}</span>
                        كود: <span class="badge badge-danger"> {{ $teacherInfo->ID }}</span>
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

        @include('back.teacher_subjects.form')

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-center text-md-nowrap" id="example1">
                        <thead class="thead-dark">
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0 nowrap_thead">الصف الدراسي/الدورة التعليمية</th>
                                <th class="border-bottom-0 nowrap_thead">المادة</th>
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

