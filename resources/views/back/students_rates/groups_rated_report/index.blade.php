
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
        flatpickr(".datePicker", {
            enableTime: false,
            noCalendar: false,
            dateFormat: "Y-m-d",
        });
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
                        <form method="post" action="{{ url('students_estimates/groups_rated_pdf') }}" id="form">
                            @csrf
                            <input type="hidden" id="res_id" value="" />

                            <div class="pd-30 pd-sm-40 bg-warning-gradient">
                                <div class="row row-xs">
                                    <div class="col-md-4">
                                        <label for="start">تاريخ البداية</label>
                                        <i class="fas fa-star require_input"></i>
                                        <input type="text" placeholder="تاريخ البداية" class="form-control datePicker" name="start" id="start" required style="font-weight: bold;text-align: center;"/>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="end">تاريخ النهاية</label>
                                        <i class="fas fa-star require_input"></i>
                                        <input type="text" placeholder="تاريخ النهاية" class="form-control datePicker" name="end" id="end" required style="font-weight: bold;text-align: center;"/>
                                    </div>

                                    <div class="col-md-1">
                                        <label for="name">بحث</label>
                                        <button type="submit" id="search" class="btn btn-primary btn-block">بحث</button>
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

