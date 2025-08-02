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
                                    <th rowspan="2">التصنيف</th>
                                    <th rowspan="2">كود الصنف</th>
                                    <th rowspan="2">اسم الصنف</th>
                                    <th rowspan="2">الكمية</th>
                                    <th rowspan="2">الوحدة</th>
                                    <th colspan="2">سعر التكلفة</th>
                                    <th colspan="2">سعر البيع</th>
                                </tr>
                                <tr>
                                    <th>سعر</th>
                                    <th>إجمالي</th>
                                    <th>سعر</th>
                                    <th>إجمالي</th>
                                </tr>
                                </thead>
                                <tbody>
                                <td>
                                    اختر الفرع والمخزن لعرض الأضناف
                                </td>
                                </tbody>
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
                        url: `{{ url('reports/itemAll/stores') }}/${selectedValue}`,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend:function () {
                            $("#selectStore").empty();
                            $('form [id^=errors]').text('');
                        },
                        success: function(res) {
                            if(res.length){
                                alertify.set('notifier','position', 'bottom-right');
                                alertify.set('notifier','delay', 2);
                                alertify.success("تم جلب الخزائن المتعلقة بهذا الفرع");

                                //$("#treasury").append(`<option value="" disabled >-- اختر فرع --</option>`);
                                $.each(res, function(index, value){
                                    $("#selectStore").append(`<option value='${value.id}'>${value.name}</option`);
                                });

                            }
                            else{
                                alertify.set('notifier','position', 'bottom-right');
                                alertify.set('notifier','delay', 2);
                                alertify.error("لاتوجد خزائن متعلقة بهذا الفرع");
                            }
                        }
                    });
                }
            });

            $("#searchArea #search").click(function(){
                let branchVal = $("#selectBranch").val();
                let storeVal = $("#selectStore").val();

                if(branchVal){
                    if(!storeVal){
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.error("اختر المخزن");
                    }
                    else{

                        $.ajax({
                            url: `{{ url('reports/itemAll/get') }}/${storeVal}`,
                            type: 'GET',
                            dataType: 'json',
                            beforeSend:function () {
                                $('table tbody').empty();
                            },
                            success: function(res) {
                                if(res.length){
                                    alertify.set('notifier','position', 'bottom-right');
                                    alertify.set('notifier','delay', 2);
                                    alertify.success("تم جلب الخزائن المتعلقة بهذا الفرع");

                                    //$("#treasury").append(`<option value="" disabled >-- اختر فرع --</option>`);
                                    $.each(res, function(index, value){
                                        $("table tbody").append(`
                                        <tr>
                                            <td>${(index + 1)}</td>
                                            <td>${value['product_category_rel_products']['name']}</td>
                                            <td>${value['internal_code']}</td>
                                            <td>${value['name_ar']}</td>
                                            <td>${value['quantity']}</td>
                                            <td>${value['unit_rel_products']['name']}</td>
                                            <td>${value['cost_price']}</td>
                                            <td>${value['cost_price'] * value['quantity']}</td>
                                            <td>${value['sell_price']}</td>
                                            <td>${value['sell_price'] * value['quantity']}</td>
                                        </tr>
                                        `);
                                    });

                                }
                                else{
                                    alertify.set('notifier','position', 'bottom-right');
                                    alertify.set('notifier','delay', 2);
                                    alertify.error("لاتوجد خزائن متعلقة بهذا الفرع");
                                }
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
