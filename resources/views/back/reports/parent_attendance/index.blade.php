
@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    <style>
        .ajs-success, .ajs-error{
            min-width: 500px !important;
        }
        #related_data{display: none;}

        #related_data h5 {
            text-align: center !important;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 0 !important; 
        }
        #related_data select {
            height: 150px !important;    
            margin: 0 0 10px !important;
        }
        #related_data select option{
            height: 22px !important;
            padding: 4px 10px;
            font-size: 12px !important;
            margin: 5px 0 !important;
            font-weight: bold;
            border-radius: 5px;
        }
    </style>
@endsection

@section('footer')  
    <script>       
        // remove all errors when close modal
        $('.modal').on('hidden.bs.modal', function(){
            $('form [id^=errors]').text('');
        });
        


        // cancel enter button 
        $(document).keypress(function (e) {
            if(e.which == 13){
                e.preventDefault();  
            }
        });

        // selectize
        $('.selectize').selectize({
            hideSelected: true
        });

        // flatpickr
        flatpickr(".datePicker", {
            dateFormat: "d-m-Y",
            defaultDate: new Date()
        });
    </script>


    <script>
    </script>

    {{-- start when click to button form submit--}}
    <script>
        $(document).on('submit', 'form', function(e) {
            e.preventDefault();

            const parent_id = $('#parent_id').val();
            const from = $('#from').val();
            const to = $('#to').val();
            const students = $('#students').val() || [];
            const groups = $('#groups').val() || [];

            if(!parent_id || !from || !to || students.length == 0 || groups.length == 0){
                alertify.dialog('alert')
                        .set({transition:'slide',message: `
                            <div style="text-align: center;font-weight: bold;">
                                <p style="color: #000; font-size: 14px;line-height: 1.6rem;">
                                    ⚠️ اختر ولي أمر، وطالبًا واحدًا أو أكثر 🧑‍🎓، ومجموعة تعليمية واحدة أو أكثر 📚، ثم حدِّد تاريخ البداية 📅 والنهاية قبل عرض التقرير 📄
                                </p>
                            </div>
                        `, 'basic': true})
                        .show();  

                return false;
            }else{
                $("form").find('input[name="_token"]').remove();
                let formData = $("form").serialize();
                let printUrl = "{{ url('parents/report/attendance/result/pdf') }}?" + formData;
    
                window.location.href = printUrl;
            }
        });
    </script>
    {{-- end when click to button form submit --}}

    {{-- start when change parent_id --}}
    <script>
        $(document).on('change', '#parent_id', function(){
            const parentId = $(this).val();

            if(parentId){ 
                $.ajax({
                    url: "{{ url('parents/related-data') }}",
                    type: 'GET',
                    data: { parent_id: parentId },
                    beforeSend: function() {
                        $('#related_data').hide();
                        $('#students').empty();
                        $('#groups').empty();
                    },
                    success: function(res) {
                        if(res.students && res.students.length > 0) {
                            $.each(res.students, function(index, student) {
                                $('#students').append(`<option value="${student.ID}">( ${index+1} ) ${student.ID} - ${student.TheName}</option>`);
                            });

                            $.each(res.groups, function(index, group) {
                                $('#groups').append(`<option value="${group.groupId}">( ${index+1} ) ${group.groupName}</option>`);
                            });

                            $('#related_data').show();
                        } else if(res.no_related) {
                            alertify.set('notifier','position', 'top-center');
                            alertify.set('notifier','delay', 4);
                            alertify.error(res.no_related);
                        }
                    },
                    error: function() {
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 4);
                        alertify.error('⚠️ حدث خطأ أثناء جلب البيانات 📄');
                    }
                });
                
            } else {
                $('#related_data').hide(); 
            }
        });
    </script>
    {{-- end when change parent_id --}}
@endsection


@section('content')
    <div class="container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header text-danger" style="display: block !important;text-align: center;margin-bottom: 15px;">
            <h4 class="content-title mb-5 my-auto">{{ $pageNameAr }}</h4>
        </div>
        <!-- breadcrumb -->

        @if (session('notFound'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('notFound') }}

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="float: left;font-size: 30px;">&times;</span>
                </button>
            </div>
        @endif
        
        <div class="card bg bg-primary" style="padding: 20px 0 !important;">
            <div class="card-body">
                <form>
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <div>
                                <select  name="parent_id" class="parent_id selectize" id="parent_id" required>
                                    <option value="" selected>اختر ولي أمر</option>                              
                                    @foreach ($parents as $parent)
                                        <option value="{{ $parent->ID }}">
                                            {{ $parent->ID }} - {{ $parent->TheName0 }}
                                        </option>                              
                                    @endforeach
                                  </select>
                            </div>
                            <bold class="text-danger" id="errors-parent_id" style="display: none;"></bold>
                        </div>    
                    
                                        
                        <div class="col-md-2">
                            <div>
                                <input type="text" class="form-control dataInput datePicker" placeholder="من" id="from" name="from" required>
                            </div>
                            <bold class="text-danger" id="errors-from" style="display: none;"></bold>
                        </div>    
                        
                        <div class="col-md-2">
                            <div>
                                <input type="text" class="form-control dataInput datePicker" placeholder="الي" id="to" name="to" required>
                            </div>
                            <bold class="text-danger" id="errors-to" style="display: none;"></bold>
                        </div>    

                        <div class="col-md-2">
                            <div>
                                <button type="submit" class="btn btn-warning-gradient btn-block" style="height: 30px;padding: 0 20px !important;">عرض</button>
                            </div>
                            <bold class="text-danger" id="errors-to" style="display: none;"></bold>
                        </div>    
                    </div>

                    <div class="card bg bg-info-transparent" style="padding: 20px !important; margin-top: 50px;" id="related_data">
                        <h5 class="text-center">بيانات الطلاب والمجموعات التعليمية التابعة لولي الأمر</h5>
                        <div class="card-body"></div>
                        
                            <div class="row mb-3">

                                <!-- قائمة الطلاب -->
                                <div class="col-md-6">
                                    <label for="students" style="color: #000;">🧑‍🎓 الطلاب</label>
                                    <select id="students" name="students[]" class="form-control" multiple></select>
                                </div>

                                <!-- قائمة المجموعات التعليمية -->
                                <div class="col-md-6">
                                    <label for="groups" style="color: #000;">📚 المجموعات التعليمية</label>
                                    <select id="groups" name="groups[]" class="form-control" multiple></select>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

