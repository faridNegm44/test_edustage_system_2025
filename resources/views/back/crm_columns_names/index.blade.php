
@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')

@endsection

@section('footer')  
    <script>     
        // get last order number when change category
        const category = document.querySelector('#category');
        category.addEventListener('change', function(e){
            const categoryValue = e.target.value;

            document.querySelector('.modal #save').disabled = true;        
            document.querySelector('.spinner_request').setAttribute("style", "display: inline-block;");

            $.ajax({
                type: 'GET',
                url: `{{ url('crm/columns_name/lastOrderNumber/${categoryValue}') }}`,
                processData: false,
                contentType: false,
                success: function(res){
                    const orderInputSelect = document.querySelector('#order');
                    orderInputSelect.value = res;

                    document.querySelector('.modal #save').disabled = false;
                    document.querySelector('.spinner_request').style.display = 'none';
                    
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 4);
                    alertify.success("تم جلب ترتيب أخر عنصر للمجموعة بنجاح");
                }
            });
        });


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
            $(this).find("input").not("[name='_token']").val('');
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
                ajax: `{{ url('/crm/columns_name/datatable') }}`,
                dataType: 'json',
                columns: [
                    {data: 'category', name: 'category'},
                    {data: 'order', name: 'order'},
                    {data: 'name_ar', name: 'name_ar'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "bDestroy": true,
                language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "الكل"]]
            });
        });
    </script>

    {{-- add, edit, delete => script --}}
    @include('back.crm_columns_names.add')
    @include('back.crm_columns_names.edit')
    @include('back.crm_columns_names.delete')
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

        @include('back.crm_columns_names.form')

        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover text-center text-md-nowrap" id="example1">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0" style="width: 25%;">القسم</th>
                                        <th class="border-bottom-0" style="width: 25%;">ترتيب العنصر حسب المجموعة</th>
                                        <th class="border-bottom-0" style="width: 25%;">الإسم بالعربية</th>
                                        <th class="border-bottom-0">الحالة</th>
                                        <th class="border-bottom-0">التحكم</th>
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

