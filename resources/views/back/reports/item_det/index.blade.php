@extends('back.layouts.app')

@section('title')
    {{$pageNameAr}}
@endsection

@section('header')
    <style>
        @media screen and (max-width: 767px) { /* Mobile */
            .main-content .offcanvas {
                width: 90%;
            }
            #div_datatable{
                overflow-x: auto;
            }
        }
        @media screen and (min-width: 768px) and (max-width: 1199px) { /* Tablet */
            .main-content .offcanvas {
                width: 90%;
            }
        }
        @media (min-width: 1200px) { /* Large Screen */
            .main-content .offcanvas {
                width: 60%;
            }
        }
        .text-bold{
            font-weight: bold !important;
        }
        #spinner-div {
            position: absolute;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 2;
        }

        tfoot th{
            font-weight: bold !important;
            color: red;
            font-size: 16px;
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        @include('back.expenses.form')

        <div class="page-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" style="margin-bottom: 30px;">
                            {{ $pageNameAr }}
                        </h4>

                        <div id="searchArea" style="background: rgb(216, 216, 240);padding: 10px;margin-bottom: 10px;">
                            <div class="row">
                                <div class="col-lg-3">
                                    <select class="form-control select2" id="selectBranch" style="display: block;width: 100%;">
                                        <option value="" selected disabled>-- اختر فرع --</option>
                                        @foreach ($branches as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3">
                                    <select class="form-control select2" id="selectStore" style="display: block;width: 100%;">
                                        <option value="" selected disabled>-- اختر المخزن --</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <select class="form-control select2" id="selectItem" style="display: block;width: 100%;">
                                        <option value="" selected disabled>-- اختر الصنف --</option>
                                    </select>
                                </div>
                                <div class="col-lg-1">
                                    <button type="button" class="btn btn-primary" id="search" style="width: 100%;text-align: center;display: block;">
                                        <i class="fab fa-searchengin font-size-18"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- table --}}
                        <div id="div_datatable">
                            <table id="" class="table table-hover dt-responsive w-100 table-striped table-bordered text-center">
                                <thead class="table-light">
                                    <tr style="font-weight: bold;">
                                        <th rowspan="2">#</th>
                                        <th rowspan="2">التاريخ</th>
                                        <th rowspan="2">نوع</th>
                                        <th rowspan="2">الجهه</th>
                                        <th rowspan="2">لينك الإذن</th>
                                        <th colspan="3">تفاصيل</th>
                                        <th colspan="3">رصيد</th>
                                    </tr>
                                    <tr>
                                        <th>كمية</th>
                                        <th>قيمة</th>
                                        <th>إجمالي</th>
                                        <th>كمية</th>
                                        <th>قيمة</th>
                                        <th>إجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <td>
                                    اختر الفرع والمخزن لعرض الأضناف
                                </td>
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

    <script>
        $(document).ready(function () {

            $(document).on('change' , '#selectBranch' , function () {

                $('form [id^=errors]').text('');
                let selectedValue = $(this).val();

                if(selectedValue != null){
                    $.ajax({
                        url: `{{ url('reports/itemDet/getStore') }}/${selectedValue}`,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend:function () {
                            $("#selectStore").empty();
                            $('form [id^=errors]').text('');
                        },
                        success: function(res) {
                            if(res.length){
                                console.log(res);
                                alertify.set('notifier','position', 'top-center');
                                alertify.set('notifier','delay', 2);
                                alertify.success("تم جلب المخازن المتعلقة بهذا الفرع");

                                $("#selectStore").append(`<option value="" disabled >-- اختر المخزن --</option>`);
                                $.each(res, function(index, value){
                                    $("#selectStore").append(`<option value='${value['id']}'>${value['name']}</option`);
                                });
                                $("#selectStore").val(null).trigger();

                            }
                            else{
                                alertify.set('notifier','position', 'top-center');
                                alertify.set('notifier','delay', 2);
                                alertify.error("لاتوجد مخازن متعلقة بهذا الفرع");
                            }
                        }
                    });
                }
            });

            $(document).on('change' , '#selectStore' , function () {

                $('form [id^=errors]').text('');
                let selectedValue = $(this).val();

                if(selectedValue != null){
                    $.ajax({
                        url: `{{ url('reports/itemDet/getProduct') }}/${selectedValue}`,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend:function () {
                            $("#selectItem").empty();
                            $('form [id^=errors]').text('');
                        },
                        success: function(res) {
                            if(res.length){
                                alertify.set('notifier','position', 'top-center');
                                alertify.set('notifier','delay', 2);
                                alertify.success("تم جلب الأصناف المتعلقة بهذا المخزن");

                                $("#selectItem").append(`<option value="" disabled >-- اختر الصنف --</option>`);
                                $.each(res, function(index, value){
                                    $("#selectItem").append(`<option value='${value['id']}'>${value['name_ar']}</option`);
                                });
                                $("#selectItem").val(null).trigger();

                            }
                            else{
                                alertify.set('notifier','position', 'top-center');
                                alertify.set('notifier','delay', 2);
                                alertify.error("لاتوجد أصناف متعلقة بهذا المخزن");
                            }
                        }
                    });
                }
            });

            $("#searchArea #search").click(function(){
                let branchVal = $("#selectBranch").val();
                let storeVal = $("#selectStore").val();
                let thisVal = $('#selectItem').val();

                if(branchVal){
                    if(!storeVal || !thisVal){
                        console.log(storeVal)
                        console.log(thisVal)
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.error("اختر المخزن او الصنف");
                    }
                    else{

                        let formData = new FormData();
                        formData.append("item_id", thisVal);

                        $.ajax({
                            url: `{{ url('reports/itemDet/post') }}`,
                            type: 'POST',
                            contentType: false,
                            cache: false,
                            processData: false,
                            data: formData,
                            dataType: 'json',
                            beforeSend:function () {
                                $('table tbody').empty();
                            },
                            success: function(res) {
                                alertify.set('notifier','position', 'top-center');
                                alertify.set('notifier','delay', 2);
                                alertify.success("تم جلب حركة الصنف بهذا الفرع");

                                $("table tbody").html(res['html'])
                                $("table tfoot").html(res['footer'])

                            }
                        });

                    }
                }
                else{
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error("اختر فرع أولآ");
                }
            });

        });

    </script>


@endsection
