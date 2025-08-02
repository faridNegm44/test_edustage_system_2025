@extends('back.layouts.app')

@section('title')
    {{$pageNameAr}}
@endsection

@section('header')
    <style>

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
                                    <select class="form-control select2" id="allClienstDet" style="display: block;width: 100%;">
                                        <option value="" selected disabled>-- اختر عميل --</option>
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <input type="datetime-local" class="form-control" id="from" value="">
                                </div>

                                <div class="col-lg-2">
                                    <input type="datetime-local" class="form-control" id="to" value="">
                                </div>

                                <div class="col-lg-1">
                                    <button type="button" class="btn btn-primary" id="search" style="width: 100%;text-align: center;display: block;">
                                        <i class="fab fa-searchengin font-size-18"></i>
                                    </button>
                                </div>
                                {{-- <div class="col-lg-1">
                                    <button type="button" class="btn btn-success" id="print" style="width: 100%;text-align: center;display: block;">
                                        <i class="fa fa-print font-size-18"></i>
                                    </button>
                                </div> --}}
                            </div>
                        </div>

                        {{-- table --}}
                        <div id="div_datatable">
                            <table class="table table-hover dt-responsive w-100 table-striped table-bordered text-center">
                                <thead class="table-light">
                                    <tr style="font-weight: bold;">
                                        <th>#</th>
                                        <th>التاريخ</th>
                                        <th>النوع</th>
                                        <th>لينك الإذن</th>
                                        <th>الخزنة</th>
                                        <th>لينك الإذن</th>
                                        <th>مدين (عليه)</th>
                                        <th>دائن (له)</th>
                                        <th>ملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td colspan="6" style="font-weight: bold;">اختر الفرع والعميل</td>
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

            // start change branch
                $(document).on('change' , '#selectBranch' , function () {
                    $('form [id^=errors]').text('');
                    let selectedValue = $(this).val();

                    if(selectedValue != null){
                        $.ajax({
                            url: `{{ url('reports/clientDet/getClients') }}/${selectedValue}`,
                            type: 'GET',
                            dataType: 'json',
                            beforeSend:function () {
                                $("#allClienstDet").empty();
                                $('form [id^=errors]').text('');
                                $('table tbody').empty();
                            },
                            success: function(res) {
                                if(res.length){
                                    alertify.set('notifier','position', 'top-center');
                                    alertify.set('notifier','delay', 2);
                                    alertify.success("تم جلب العملاء المتعلقين بهذا الفرع");

                                    $("#allClienstDet").append(`<option value="" selected disabled>-- اختر عميل --</option>`);
                                    $.each(res, function(index, value){
                                        $("#allClienstDet").append(`<option value='${value['id']}'>${value['name']}</option>`);
                                    });
                                    $("#selectStore").val(null).trigger();

                                }
                                else{
                                    alertify.set('notifier','position', 'top-center');
                                    alertify.set('notifier','delay', 2);
                                    alertify.error("لايوجد عملاء متعلقين بهذا الفرع");
                                }
                            }
                        });
                    }
                });
            // end change branch


            // start search
                $("#searchArea #search").click(function(){
                    let branchVal = $("#selectBranch").val();
                    let allClienstDet = $("#allClienstDet").val();
                    let from = $("#from").val();
                    let to = $("#to").val();

                    if(!branchVal || !allClienstDet){
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.error("اختر الفرع والعميل أولآ");
                    }else{



                        let formData = new FormData();
                        formData.append("branchVal", branchVal);
                        formData.append("clientAndSupp", allClienstDet);
                        formData.append("from", from);
                        formData.append("to", to);

                        $.ajax({
                            url: `{{ url('reports/supplierDet/view') }}`,
                            type: 'POST',
                            contentType: false,
                            cache: false,
                            processData: false,
                            data: formData,
                            dataType: 'json',
                            beforeSend:function () {
                                $('table tbody').empty();
                                $("#overlay_div").css('display', 'block');
                            },
                            success: function(res) {
                                if(res.html !== ''){

                                    alertify.set('notifier','position', 'top-center');
                                    alertify.set('notifier','delay', 2);
                                    alertify.success("تم جلب حركة المورد لهذا الفرع");


                                    $("table tbody").html(res['html']);

                                }
                                else{
                                    $("#overlay_div").css('display', 'none');

                                    alertify.set('notifier','position', 'top-center');
                                    alertify.set('notifier','delay', 3);
                                    alertify.error("لاتوجد حركات لهذا العميل بناءا علي هذا البحث");

                                    $("table tbody").append(`<tr><td colspan="6" style="font-weight: bold;">لاتوجد حركات لهذا العميل بناءا علي هذا البحث</td></tr>`);
                                }
                            },
                            complete:function () {
                                $("#overlay_div").css('display', 'none');
                            }
                        });
                    }
                });
            // end search

        });
    </script>
@endsection
