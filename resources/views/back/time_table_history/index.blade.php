
@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')

@endsection

@section('footer')  
    <script>             
        $(document).ready(function () {
            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ url('/time_table_history/datatable') }}`,
                dataType: 'json',
                columns: [
                    {data: 'group_id_time', name: 'group_id_time'},
                    {data: 'type_history', name: 'type_history'},
                    {data: 'class_type_time', name: 'class_type_time'},
                    {data: 'day_time', name: 'day_time'},
                    {data: 'room_user', name: 'room_user'},
                    {data: 'times', name: 'times'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'notes_time', name: 'notes_time'},
                ],
                "order": [],
                "bDestroy": true,
                language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                lengthMenu: [[50, 100, 150, -1], [50, 100, 150, "الكل"]]
            });
        });

        $("body").addClass('sidenav-toggled');
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

        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover text-center text-md-nowrap" id="example1">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0" style="width: 10% !important;">مجموعة</th>
                                        <th class="border-bottom-0" style="width: 5% !important;">ن السجل</th>
                                        <th class="border-bottom-0" style="width: 15% !important;">ن الحصة</th>
                                        <th class="border-bottom-0" style="width: 5% !important;">اليوم</th>
                                        <th class="border-bottom-0" style="width: 15% !important;">غرفة/مستخدم</th>
                                        <th class="border-bottom-0" style="width: 20% !important;">الأوقات</th>
                                        <th class="border-bottom-0" style="width: 20% !important;">مستخدم</th>
                                        <th class="border-bottom-0" style="width: 10% !important;">ملاحظات</th>
                                    </tr>
                                </thead>                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

