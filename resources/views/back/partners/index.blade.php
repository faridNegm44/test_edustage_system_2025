
@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    {{-- sweetalert --}}
    <link href="{{ url('back') }}/assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">
    {{-- fileupload --}}
    <link href="{{ asset('back/assets/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        
    </style>
@endsection

@section('footer')  
    <script src="{{ url('back') }}/assets/plugins/sweet-alert/jquery.sweet-alert.js"></script>
    <script src="{{ url('back') }}/assets/plugins/sweet-alert/sweetalert.min.js"></script>
    <script src="{{ url('back') }}/assets/js/sweet-alert.js"></script>
    <!-- fileupload -->
    <script src="{{ asset('back/assets/file-upload-with-preview.min.js') }}"></script>
    <script> new FileUploadWithPreview('file_upload') </script>

    

    <script>
        // open modal when click button (insert)
        document.addEventListener('keydown', function(event){
            if( event.which === 45 ){
                $('#exampleModalCenter').modal('show');
                document.querySelector('#exampleModalCenter .modal-header .modal-title').innerText = 'إضافة';
                document.querySelector('#exampleModalCenter .modal-footer #save').setAttribute('style', 'display: inline;');
                document.querySelector('#exampleModalCenter .modal-footer #update').setAttribute('style', 'display: none;');
                $('.dataInput').val('');
            }
        });
    </script>
    
    <script>
        // remove all errors and inputs data when close modal
        $('.modal').on('hidden.bs.modal', function(){
            $('form [id^=errors]').text('');
            $(this).find("input").not("[name='_token']").val('');
        });
    </script>

    <script>
        // when click on add button
        $(".add").on('click', function(){
            $("#first_money").attr('readonly', false);
            $('.dataInput').val('');
        });        
    </script>


    <script>       
        $(document).ready(function () {
            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ url($pageNameEn.'/datatable') }}`,
                dataType: 'json',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'action', name: 'action', orderable: false},
                    {data: 'status', name: 'status'},
                    {data: 'name', name: 'name'},
                    //{data: 'first_money', name: 'first_money'},
                    {data: 'commission_percentage', name: 'commission_percentage'},
                    //{data: 'remaining_money', name: 'remaining_money'},
                    {data: 'phone', name: 'phone'},
                    {data: 'address', name: 'address'},
                    {data: 'notes', name: 'notes'},
                    {data: 'created_at', name: 'created_at'},
                ],
                "bDestroy": true,
                language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "الكل"]],
                order: [[0, 'desc']]
            });


            // focus first input when open modal
            $('.modal').on('shown.bs.modal', function(){
                $('.dataInput:eq(0)').focus();                
            });
        });
    </script>

    {{-- add, edit, delete => script --}}
    @include('back.partners.add')
    @include('back.partners.edit')
    @include('back.partners.delete')
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

        @include('back.partners.form')

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-center text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 nowrap_thead">#</th>
                                <th class="border-bottom-0 nowrap_thead">التحكم</th>
                                <th class="border-bottom-0 nowrap_thead">الحالة</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 100px !important;max-width: 100px !important;">الإسم</th>
                                {{--<th class="border-bottom-0 nowrap_thead">الرصيد الإفتتاحي</th>--}}
                                <th class="border-bottom-0 nowrap_thead">النسبة %</th>
                                {{--<th class="border-bottom-0 nowrap_thead">الرصيد الحالي للشريك</th>--}}
                                <th class="border-bottom-0 nowrap_thead">موبايل</th>
                                <th class="border-bottom-0 nowrap_thead">العنوان</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 200px !important;max-width: 200px !important;">ملاحظات</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 100px !important;max-width: 100px !important;">تاريخ الإنشاء</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

