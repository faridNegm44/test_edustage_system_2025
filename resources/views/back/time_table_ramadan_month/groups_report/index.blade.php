
@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    <style>
        .ajs-error{
            width: 400px !important;
        }

        .ajs-success{
            width: 350px !important;
        }

    </style>
@endsection

@section('footer')  
    <script>
        // selectize
        $('.selectize').selectize();

        // get groups when change years_mat
        $(document).ready(function () {
            $("#years_mat").change(function(){
                var year = $(this).val();
                
                $.ajax({
                    url: `{{ url('time_table_ramadan_month/groups_report/get_groups') }}/${year}`,
                    type: 'GET',
                    beforeSend: function(){
                        $('.groups option').remove();
                    },
                    success: function(res){    
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.success("تم جلب الجروبات المتعلقة بالصف الدراسي بنجاح");
                            
                        var selectize = $('.groups')[0].selectize;
                        selectize.clearOptions();
                        
                        res.allMats.forEach(function(item, index) {
                            const text = `${index+1} -- ( ${item.theMat} )  -- ${item.groupName == null ? 'جروب: ****' : item.groupName}`;
                            selectize.addOption({
                                value: item.groupId, 
                                text: text
                            }); 
                        });
            
                        selectize.refreshOptions(false);
                    }
                });
            })
        });


        // check if groups and years_mat VAL == null
        $(document).ready(function () {    
            $("#search").click(function(e){
                if($('.groups').val().length == 0 || $('#years_mat').val().length == 0) {
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 7);
                    alertify.error("غير مسموح: يجب اختيار صف دراسي أولا ثم جروب أو أكثر");
                    e.preventDefault();
                }
            });
        });
    </script>

    {{--  start open and closed all according   --}}
    <script>
        $(document).ready(function() {
            $(".main-header").addClass("bg bg-warning-gradient");
            $(".main-content").addClass("bg bg-warning-gradient");
        });
    </script>
    {{--  end open and closed all according   --}}
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

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="float: left;font-size: 30px;">&times;</span>
                </button>
            </div>
        @endif
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ url('time_table_ramadan_month/groups_pdf') }}" id="form">
                            @csrf
                            <input type="hidden" id="res_id" value="" />               

                            <div class="pd-30 pd-sm-40 bg-gray-200">
                                <div class="row row-xs">
                                    <div class="col-md-12 col-xs-12">
                                        <label for="name">الصفوف الدراسية</label>
                                        <i class="fas fa-star require_input"></i>
                                        <select id="years_mat" name="years_mat" class="selectize dataInput">
                                            <option value="" selected disabled>الصفوف الدراسية</option>
                                            @foreach ($tblYearsMat as $mat)
                                                <option value="{{ $mat->TheYear }}">
                                                    {{ $mat->TheYear }}                                              
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-12 col-xs-12">
                                        <label for="name">الجروبات</label>
                                        <i class="fas fa-star require_input"></i>
                                        <select name="groups[]" class="selectize groups" multiple>

                                        </select>
                                    </div>
{{--                                      
                                    <div class="col-md-12 col-xs-12">
                                        <label for="name">الجروبات</label>
                                        <i class="fas fa-star require_input"></i>
                                        <select name="groups[]" class="form-control groups" multiple>
                                            <option class="text-center text-danger" disabled style="margin-top: 60px;font-size: 15px;">اختر الصف الدراسي أولا</option>
                                            <option class="text-center text-danger" disabled style="font-size: 15px;">لإظهار الجروبات المتاحة لة</option>    
                                        </select>
                                    </div>  --}}
                                    
                                    <div class="col-md-12 col-xs-12">
                                        <br>
                                        <button type="submit" id="search" class="btn btn-success btn-block">
                                            بحث
                                            <span class="spinner-border spinner-border-sm spinner_request2" role="status" aria-hidden="true"></span>
                                          </button>                      
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

