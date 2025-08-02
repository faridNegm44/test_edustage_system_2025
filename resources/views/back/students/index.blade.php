@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    <style>
        .crm_categories{
            padding: 10px;
            border: 1px dotted #9d9d9d;
            border-radius: 4px;
            width: 30%;
            margin: 30px auto;
            box-shadow: 10px 7px 23px -8px rgb(151 156 209);
        }

        .categName{
            border: 1px dotted;
            width: 35%;
            padding: 10px;
            margin: 10px auto 20px;
            box-shadow: 7px 7px 5px 0px rgb(182 182 182 / 75%);
            font-weight: bold;text-align: center;
            background: linear-gradient(135deg, hsla(0, 0%, 69%, 1) 0%, hsla(227, 50%, 47%, 1) 51%);
            color: #FFF !important;

        }
        @media (min-width: 1200px) {
            .modal-xl {
                max-width: 95%;
            }
        }
        textarea{
            box-shadow: 10px 7px 23px -8px rgb(151 156 209);
        }
        
        .modal textarea{
            box-shadow: none;
        }

        td{
            font-size: 10px !important;
            font-weight: bold;
        }

        tbody td:nth-child(7),
        tbody td:nth-child(8) {
            text-align: right;
        }

        .ThePhone1, .ThePhone2{
            font-weight: bold;
            font-size: 11px;
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
    </style>
@endsection

@section('footer')  
    <script>
        $("body").addClass('sidenav-toggled');
        
        // selectize
        $('.selectize').selectize();

        // flatpickr
        flatpickr(".datePicker");


        // remove all errors and inputs data when close modal
        $('.modal').on('hidden.bs.modal', function(){
            $('form [id^=errors]').text('');
            $(this).find("input").not("[name='_token']").val('');
            document.querySelector("#image_preview_form").src = `{{ url('back/images/students/df_image.png') }}`;
        });
        
        


        // remove all values when click .add button
        $('.add').on('click', function(){
            $('.dataInput').val('');

            $('#NatID, #CityID').each(function() {
                $(this)[0].selectize.clear();
            });
        });



        // when click button copy_parent_info
        $("#copy_parent_info").on('click', function(e){
            e.preventDefault();
            const parentVal = $("#ParentID").val();

            if(!parentVal){
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.error("اختر ولي أمر أولاً");

            }else{
                const parentSelect = $('#ParentID')[0].selectize;

                if (parentSelect.getValue()) {
                    const { email, whats, nat, city } = parentSelect.options[parentSelect.getValue()];

                    $("#TheEmail").val(email);
                    $("#ThePhone").val(whats);
                    $("#NatID")[0].selectize.setValue(nat);
                    $("#CityID")[0].selectize.setValue(city);
                }
            } // end else if !parentVal
        
        });

        // datatable
        $(document).ready(function () {
            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ url($pageNameEn.'/datatable') }}`,
                dataType: 'json',
                columns: [
                    {data: 'action', name: 'action', orderable: false},
                    {data: 'TheName', name: 'TheName'},
                    {data: 'ID', name: 'ID'},
                    {data: 'TheDate1', name: 'TheDate1'},
                    {data: 'nat_city', name: 'nat_city'},
                    {data: 'TheEduType', name: 'TheEduType'},
                    {data: 'TheTestType', name: 'TheTestType'},
                    {data: 'phones', name: 'phones'},
                    {data: 'TheEmail', name: 'TheEmail'},
                    {data: 'academicYearName', name: 'academicYearName'},
                    {data: 'TheExplain', name: 'TheExplain'},
                    {data: 'TheNotes', name: 'TheNotes'},
                    {data: 'TheStatus', name: 'TheStatus'},
                    {data: 'TheStatusDate', name: 'TheStatusDate'},
                ],
                "bDestroy": true,
                "order": [[ 2, "desc" ]],
                language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "الكل"]]
            });
        });
    </script>



    {{-- add, edit, delete => script --}}
    @include('back.students.add')
    @include('back.students.edit')
    @include('back.students.delete')


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

        @include('back.students.form')

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center text-md-nowrap" id="example1" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 nowrap_thead" style="width: 110px !important;min-width: 110px !important;">التحكم</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 110px !important;min-width: 110px !important;">الإسم</th>
                                <th class="border-bottom-0 nowrap_thead">كود</th>
                                <th class="border-bottom-0 nowrap_thead">تاريخ التسجيل</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 80px !important;min-width: 80px !important;"> الإقامة</th>
                                <th class="border-bottom-0 nowrap_thead">نظام التعليم</th>
                                <th class="border-bottom-0 nowrap_thead">نظام الاختبارات</th>
                                <th class="border-bottom-0 nowrap_thead">موبايل</th>
                                <th class="border-bottom-0 nowrap_thead">الإيميل</th>
                                <th class="border-bottom-0 nowrap_thead">السنة</th>
                                <th class="border-bottom-0 nowrap_thead">الوصف</th>
                                <th class="border-bottom-0 nowrap_thead">ملاحظات</th>
                                <th class="border-bottom-0 nowrap_thead">الحالة</th>
                                <th class="border-bottom-0 nowrap_thead">تاريخ الحالة</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

