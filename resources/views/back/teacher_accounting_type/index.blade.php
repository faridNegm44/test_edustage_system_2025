
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
    
        // selectize
        $('.selectize').selectize();
        
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

            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ url($pageNameEn) }}/datatable`,
                dataType: 'json',
                columns: [
                    {data: 'ID', name: 'ID'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'TheName', name: 'TheName'},
                    {data: 'static_value', name: 'static_value'},
                    {data: 'percentage_value', name: 'percentage_value'},
                    {data: 'tax', name: 'tax'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "bDestroy": true,
                "order": [[ 1, "desc" ]],
                language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "الكل"]]
            });
        });
    </script>

    {{-- add, edit, delete => script --}}
    @include('back.teacher_accounting_type.add')
    @include('back.teacher_accounting_type.edit')
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

        @include('back.teacher_accounting_type.form')

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-center text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">كود المدرس</th>
                                <th class="border-bottom-0">تاريخ الاضافة</th>
                                <th class="border-bottom-0">المدرس</th>
                                <th class="border-bottom-0">قيمة ثابتة</th>
                                <th class="border-bottom-0">نسبة %</th>
                                <th class="border-bottom-0">ضريبة</th>
                                <th class="border-bottom-0">التحكم</th>
                            </tr>
                        </thead>                                
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

