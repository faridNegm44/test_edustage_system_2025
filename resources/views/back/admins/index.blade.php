@extends('back.layouts.app')

@section('title')
    المديرين
@endsection

@section('header')
    <style>
        @media screen and (min-width: 481px) and (max-width: 768px) { 
            .main-content .offcanvas {
                width: 90%;
            }
        }
       @media (min-width: 768px) { /* Tablet */
            .main-content .offcanvas {
                width: 90%;
            }
        }
        @media (min-width: 992px){ /* Large Screen */
            .main-content .offcanvas {
                width: 60%;
            }
        }
    </style>
@endsection

@section('footer')
    {{-- start add script --}}
        @include('back.admins.add')
    {{-- end add script --}}


    {{-- start edit script --}}
        @include('back.admins.edit')
    {{-- end edit script --}}


    {{-- start change offcanavas title and background--}}
        <script>
            // add
            $(document).on("click" , ".page-content .card-body .add" ,function(e){
                $('.offcanvas .offcanvas-title').text('إضافة');
                $('.offcanvas .offcanvas-header').css('background', '#727bb7');
                $('.offcanvas button[id=save]').css('display', 'inline');
                $('.offcanvas button[id=update]').css('display', 'none');
            });

            // edit
            $(document).on("click" , "#datatable tr .edit" ,function(e){
                $('.offcanvas .offcanvas-title').text('تعديل');
                $('.offcanvas .offcanvas-header').css('background', '#4ec798');
                $('.offcanvas button[id=update]').css('display', 'inline');
                $('.offcanvas button[id=save]').css('display', 'none');

            });
        </script>
    {{-- end change offcanavas title and background--}}



    {{-- start datatable script --}}
        <script>
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json",
                ajax: "{{ url('admin/admins/datatable_admins') }}",
                columns: [
                    {data: 'image', name: 'image'},
                    {data: 'user', name: 'user'},
                    {data: 'contact', name: 'contact'},
                    {data: 'last_login_time', name: 'last_login_time'},
                    {data: 'gender', name: 'gender'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'},
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json',
                },
                dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print'
                // ],
                "aoColumnDefs": [
                    { "bSortable": false, "aTargets": [ 0 ] },
                ],
                order: [[0, "DESC"]]
            });
        </script>
    {{-- end datatable script --}}
    
    @include('back.admins.delete')
@endsection

@section('content')
    <div class="main-content">

        @include('back.admins.form')
        
        <div class="page-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" style="margin-bottom: 30px;">
                            @lang('app.admins')

                            <span style="position: relative;top: -7px;">
                                <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light mb-2 me-2 add" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                                    <i class="mdi mdi-plus me-1"></i>
                                    إضافة
                                </button>
                            </span>
                        </h4>

                        {{-- table --}}        
                        <div style="overflow-x: auto;">
                            <table id="datatable" class="table table-hover dt-responsive w-100 table-striped table-bordered">
                                <thead class="table-light">                                
                                    <tr>
                                        <th>صورة</th>
                                        <th>المستخدم</th>
                                        <th>وسائل الإتصال</th>
                                        <th>أخر إتصال</th>
                                        <th>النوع</th>
                                        <th>الحالة</th>
                                        <th>التحكم</th>
                                    </tr>
                                </thead>
                            </table>   
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Include Footer --}}
        @include('back.layouts.footer')
    </div>
@endsection
