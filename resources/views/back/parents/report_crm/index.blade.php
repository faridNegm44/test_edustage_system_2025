@extends('back.layouts.app')

@section('title') {{ $nameAr }}@endsection


@section('header')
    <link href="{{ url('back') }}/assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="{{ url('back') }}/assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/plugins/datatable/css/responsive.dataTables.min.css" rel="stylesheet">

    <style>
        #card_groups select option:disabled{
            font-size: 7px !important;
        }
    </style>
@endsection

@section('footer')
    <script src="{{ url('back') }}/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('back') }}/assets/plugins/datatable/js/dataTables.bootstrap4.js"></script>
    <script src="{{ url('back') }}/assets/js/modal.js"></script>

    <script>
        $(document).ready(function () {
            $(".select2_select2").select2();
        });
    </script>


    {{-- <script>
        const formSearchBtn = document.querySelector('#card_groups form .submit');
        formSearchBtn.addEventListener('click', (e) => {
            e.preventDefault();
            
            const formSelectValue = document.querySelector('#card_groups form #poll_hr_group').value;
            const url = `{{ url('dashboard/polls_hr/reports/groups/${formSelectValue}') }}`;

            $.ajax({
                type: "post",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: url,
                success: function (res) {
                    $('.modal').modal('hide');
                    $('#answers_to_polls_questions_table').DataTable().ajax.reload( null, false );

                    $(`${pollsAnswersToQuestionsModal} form input`).not('[name="_token"]').val('');
                    $(`${pollsAnswersToQuestionsModal} form select`).find('option:first').prop('selected', true);
                    
                    notif({
                        msg: "تمت إضافة إجابات السؤال بنجاح ",
                        type: "success",
                    });

                    window.location.reload();
                },
                beforeSend:function () {
                    $(`${pollsAnswersToQuestionsModal} form [id^=errors]`).text('');
                },
                error: function (res) {
                    $.each(res.responseJSON.errors, function (index , value) {
                        $(`${pollsAnswersToQuestionsModal} form #errors-${index}`).css('display' , 'block').text(value);
                    });
                }
            });

        });
    </script> --}}

@endsection

@section('content')

    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <h4 class="content-title mb-2">{{ $nameAr }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $nameAr }}</li>
                </ol>
            </nav>
        </div>
    </div>


    <div class="col-xl-12" id="card_groups">
        <div class="card">
            <div class="card-header pb-0 pd-t-25" style="background: #dcdcdc;padding: 30px 20px 30px;">
                <div class="">
                    <form action="{{ url('dashboard/polls_hr/reports/groups') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-9">
                                <div class="form-group">
                                  <select class="form-control select2_select2" id="poll_hr_group" name="poll_hr_group" style="width: 100%;">
                                    <option value="" disabled selected>إختر مجموعة</option>                                        
                                    @foreach ($groups_hr as $group)
                                        <option value="{{ $group->id }}">{{ $group->title }}</option>                                        
                                    @endforeach
                                  </select>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-3">
                                <button type="submit" class="btn btn-primary submit" title="بحث">بحث</button>
                            </div>
                        </div>
                    </form>               
                </div>
            </div>
        </div>
    </div>
@endsection