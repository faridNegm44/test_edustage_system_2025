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
            document.querySelector("#image_preview_form").src = `{{ url('back/images/parents/df_image.png') }}`;
        });
        
        


        // remove all values when click .add button
        $('.add').on('click', function(){
            $('.dataInput').val('');

            $('#NatID, #CityID').each(function() {
                $(this)[0].selectize.clear();
            });
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
                    {data: 'action', name: 'action', orderable: false},
                    {data: 'ID', name: 'ID'},
                    {data: 'TheName0', name: 'TheName0'},
                    {data: 'TheDate1', name: 'TheDate1'},
                    {data: 'nat_city', name: 'nat_city'},
                    {data: 'TheEmail', name: 'TheEmail'},
                    {data: 'phones', name: 'phones'},
                    {data: 'whats', name: 'whats'},
                    {data: 'TheStatus', name: 'TheStatus'},
                    {data: 'TheNotes', name: 'TheNotes'},
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
                order: [[ 1, "desc" ]],
                language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                lengthMenu: [[20, 50, 100, 200, -1], [20, 50, 100, 200, "الكل"]]
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
    @include('back.parents.add')
    @include('back.parents.edit')
    @include('back.parents.delete')
    @include('back.parents.crm_info_js')
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
                    <div class="col-md-2">
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
                                    
                    <div class="col-md-2">
                        <div>
                            <input type="text" class="form-control datePicker" placeholder="من" id="from" name="from">
                        </div>
                        <bold class="text-danger" id="errors-from" style="display: none;"></bold>
                    </div>    
                    
                    <div class="col-md-2">
                        <div>
                            <input type="text" class="form-control datePicker" placeholder="الي" id="to" name="to">
                        </div>
                        <bold class="text-danger" id="errors-to" style="display: none;"></bold>
                    </div>    

                    <div class="col-md-2">
                        <div>
                            <button id="search" class="btn btn-warning-gradient btn-block" style="height: 36px;font-size: 12px;font-weight: bold;">بحث</button>
                        </div>
                        <bold class="text-danger" id="errors-to" style="display: none;"></bold>
                    </div>
                    
                </div>
            </div>
        </div>
        
        @include('back.parents.form')
        @include('back.parents.crm_form')
        @include('back.layouts.duplicated_emails_modal')

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center text-md-nowrap" id="example1" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 nowrap_thead" style="width: 110px !important;min-width: 110px !important;">التحكم</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 40px !important;min-width: 40px !important;">كود</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 150px !important;min-width: 150px !important;">الإسم</th>
                                <th class="border-bottom-0 nowrap_thead">التاريخ</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 120px !important;min-width: 120px !important;"> الإقامة</th>
                                <th class="border-bottom-0 nowrap_thead">الإيميل</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 80px !important;min-width: 80px !important;">موبايل</th>
                                <th class="border-bottom-0 nowrap_thead" style="width: 80px !important;min-width: 80px !important;">واتساب</th>
                                <th class="border-bottom-0 nowrap_thead">الحالة</th>
                                <th class="border-bottom-0 nowrap_thead">ملاحظات</th>
                                <th class="border-bottom-0 nowrap_thead">السنة</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

