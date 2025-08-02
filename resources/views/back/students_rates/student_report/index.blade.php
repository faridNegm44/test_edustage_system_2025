
@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    
@endsection

@section('footer')  
    <script>
        // selectize
        $('.selectize').selectize();
    </script>
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

        @if (session('notFoundRates'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('notFoundRates') }}

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="float: left;font-size: 30px;">&times;</span>
                </button>
            </div>
        @endif
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ url('students_estimates/student_pdf') }}" id="form" >
                            @csrf
                            <input type="hidden" id="res_id" value="" />               

                            <div class="pd-30 pd-sm-40 bg-gray-200">
                                <div class="row row-xs">
                                    <div class="col-md-7 col-xs-12">
                                        <label for="name">الطلاب</label>
                                        <i class="fas fa-star require_input"></i>
                                        <select id="student_id" name="student_id" class="selectize dataInput" required>
                                            <option value="" selected disabled>الطلاب</option>
                                            @foreach ($students as $student)
                                                <option value="{{ $student->studentId }}">
                                                    {{ $student->studentName }} {{ $student->TheName0 }}                                                 
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-2 col-xs-12">
                                        <label for="name">بحث</label>
                                        <br>
                                        <button type="submit" id="update" class="btn btn-success">
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

