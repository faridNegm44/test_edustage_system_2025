
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
        .require_input{
            top: 8px !important;
        }
    </style>
@endsection

@section('footer')
    <script>


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
                        <form method="post" action="{{ url('students_estimates/groups_not_rated_pdf') }}" id="form">
                            @csrf
                            <input type="hidden" id="res_id" value="" />

                            <div class="pd-30 pd-sm-40 bg-gray-200">
                                <div class="row row-xs">
                                    <div class="col-md-4">
                                        <label for="month">الشهر</label>
                                        <i class="fas fa-star require_input"></i>
                                        <select class="form-control" name="month" id="month" required >
                                            <option value="">اختر شهر</option>
                                            <option value="01"> ( 1 ) يناير</option>
                                            <option value="02"> ( 2 ) فبراير</option>
                                            <option value="03"> ( 3 ) مارس</option>
                                            <option value="04"> ( 4 ) أبريل</option>
                                            <option value="05"> ( 5 ) مايو</option>
                                            <option value="06"> ( 6 ) يونيو</option>
                                            <option value="07"> ( 7 ) يوليو</option>
                                            <option value="08"> ( 8 ) أغسطس</option>  
                                            <option value="09"> ( 9 ) سبتمبر</option>
                                            <option value="10"> ( 10 ) أكتوبر</وoption>  
                                            <option value="11"> ( 11 ) نوفمبر</option>
                                            <option value="12"> ( 12 ) ديسمبر</option>
                                        </select>
                                    </div>

                                    <div class="col-md-1">
                                        <label for="name">بحث</label>
                                        <button type="submit" id="search" class="btn btn-success btn-block">بحث</button>
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

