
@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    {{-- fileupload --}}
    <link href="{{ asset('back/assets/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('footer')
    {{--  <!-- fileupload -->  --}}
    <script src="{{ asset('back/assets/file-upload-with-preview.min.js') }}"></script>
    <script> new FileUploadWithPreview('file_upload') </script>

    <script>       
        // cancel enter button 
        $(document).keypress(function (e) {
            if(e.which == 13){
                e.preventDefault();  
            }
        });
    </script>

    {{-- edit => script --}}
    @include('back.general_settings.edit')
@endsection






@section('content')
    <div class="container-fluid">
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">{{ $pageNameAr }}</h4>
                </div>
            </div>
        </div>

        @include('back.general_settings.form')

        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover text-center text-md-nowrap" id="example1">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0" >إسم البرنامج</th>
                                        <th class="border-bottom-0" >الوصف</th>
                                        <th class="border-bottom-0" >التلفونات</th>
                                        <th class="border-bottom-0" >العنوان</th>
                                        <th class="border-bottom-0">التحكم</th>
                                    </tr>
                                </thead>                                
                                
                                <tbody>
                                    <tr>
                                        <td class="border-bottom-0" >{{ $find->name }}</td>
                                        <td class="border-bottom-0" >{{ $find->description }}</td>
                                        <td class="border-bottom-0" >
                                            <i class="mdi mdi-phone-classic"></i> {{ $find->phone1 }}
                                            <br>
                                            <i class="mdi mdi-phone-classic"></i> {{ $find->phone2 }}
                                        </td>
                                        <td class="border-bottom-0" >{{ $find->address }}</td>
                                        <td class="border-bottom-0">
                                            <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="{{ $find->id }}">
                                                <i class="fas fa-marker"></i>
                                            </button>'
                                        </td>
                                    </tr>
                                </tbody>                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

