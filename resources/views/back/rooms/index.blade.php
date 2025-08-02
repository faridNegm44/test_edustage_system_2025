
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
        flatpickr(".datePicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i",
        });
    </script>

    <script>     
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
                    {data: 'RoomID', name: 'RoomID'},
                    {data: 'RoomName', name: 'RoomName'},
                    {data: 'RoomUser', name: 'RoomUser'},
                    {data: 'RoomPass', name: 'RoomPass'},
                    {data: 'academicYearName', name: 'academicYearName'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "bDestroy": true,
                "order": [[ 0, "desc" ]],
                language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "الكل"]]
            });
        });
    </script>

    {{-- add, edit, delete => script --}}
    @include('back.rooms.add')
    @include('back.rooms.edit')
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

        @include('back.rooms.form')

        
        <div class="panel-group1" id="accordion11">
            <div class="panel panel-default  mb-4" style="border: 2px solid #ccc;">
                <div class="panel-heading1 bg-secondary-gradient">
                    <h4 class="panel-title1" style="line-height: 0.8 !important;">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion11" href="#collapseFour1" aria-expanded="false">اكسيل</a>
                    </h4>
                </div>
                <div id="collapseFour1" class="panel-collapse collapse" role="tabpanel" aria-expanded="false" style="">
                    <div class="panel-body border">
                        <p>All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words </p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-center text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">اسم الغرفة</th>
                                <th class="border-bottom-0">اسم المستخدم</th>
                                <th class="border-bottom-0">كلمة السر</th>
                                <th class="border-bottom-0">السنة الأكاديمية</th>
                                <th class="border-bottom-0">الحالة</th>
                                <th class="border-bottom-0">التحكم</th>
                            </tr>
                        </thead>                                
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

