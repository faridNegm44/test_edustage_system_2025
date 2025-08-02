
@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    <style>
        .flatpickr-am-pm{
            display: none !important;
        }
        .ajs-error{
            width: 320px !important;
        }
        @media (min-width: 768px){
            .modal-lg {
                max-width: 80%;
            }

            .modal-xl {
                max-width: 98%;
            }
        }
        hr{
            border-top: 2px solid #4d5276;
            margin: 32px 0px 24px;
        }

        #add_rate input{
            height: 30px;
            font-weight: bold;
        }
        #add_rate select{
            height: 30px;
            font-weight: bold;
            font-size: 13px;
            padding: 0 6px;
        }
        #add_rate .table-bordered td, .table-bordered th {
            border: 1px solid #dde2ef;
            padding: 5px 10px ;
        }
        #add_rate tbody input {
            height: 22px;
            text-align: center;
        }
        #add_rate tbody input::placeholder {
            font-size: 10px;
        }
        #Eval_TeacherComment ,#Eval_TeacherSugg{
            font-size: 10px;
            font-weight: bold;
        }

        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
        #exampleModalCenterShow table tbody tr th{
            padding: 3px 10px;
        }

    </style>
@endsection

@section('footer')
    
    <script>
        // start focus the input[type="number"]
        const focusedInput = () => {
            $('input[type="number"], .focused').on('focus', function() {
                $(this).select();
            });
        }
        // end focus the input[type="number"]






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




        
        
        // start check if Eval_Att -- Eval_Part -- Eval_Eval -- Eval_HW > 10 or 40
        function chechIfValueBiggerThan (selector, minVal, maxVal){
            $(selector).on("input", function(){
                const thisVal = $(this).val();
                
                if(thisVal > maxVal){
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error(`تحذير: قيمة التقييم اكبر من ${maxVal}`);

                    $(this).css('background', '#f2bd8d')

                    setTimeout(() => {
                        $(this).css('background', '#FFF')
                    }, 1000);

                    $(this).val('');

                }
                else if(thisVal < minVal){
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error(`تحذير: قيمة التقييم يجب ان تكون اكبر من 0`);

                    $(this).css('background', '#f2bd8d')

                    setTimeout(() => {
                        $(this).css('background', '#FFF')
                    }, 1000);

                    $(this).val('');
                }
            });
        }

        
        // end check if Eval_Att -- Eval_Part -- Eval_Eval -- Eval_HW > 10 or 40



        // start sum rows
        const sumRow = () => {
            $(document).ready(function() {
                $('#add_rate table tbody .sum-input').on('input', function() {
                    let parentTr = $(this).closest('tr');

                    let sum = 0;
                    parentTr.find('.sum-input').each(function() {
                        let value = parseFloat($(this).val()) || 0;
                        sum += value;
                    });
                    
                    parentTr.find('.Eval_Degree').val(sum);
                });
            });
        }
        // end sum rows



        // start function when change inputs top like [Eval_Att--Eval_Part--Eval_Eval--Eval_HW] and run this ti table under top
        const changeInputsTop = (selector, selector2, maxVal) => {
            $(selector).on('input', () => {
                const thisVal = $(selector).val();
                $(selector2).val(thisVal);
                
                $('#add_rate table tbody .sum-input').each(function() {
                    let parentTr = $(this).closest('tr');
                    let Eval_Degree = parentTr.find('.Eval_Degree');

                    let sum = 0;
                    sum+= parseFloat(parentTr.find('.Eval_Att').val()) || 0;
                    sum+= parseFloat(parentTr.find('.Eval_Part').val()) || 0;
                    sum+= parseFloat(parentTr.find('.Eval_Eval').val()) || 0;
                    sum+= parseFloat(parentTr.find('.Eval_HW').val()) || 0;

                    Eval_Degree.val( sum );
                });
            })
        }     
        // end function when change inputs top like [Eval_Att--Eval_Part--Eval_Eval--Eval_HW] and run this ti table under top






        // start function when change inputs top cooment and sugg and run this ti table under top
        const changeInputsTopCommAndSugg = (selector, selector2) => {
            $(selector).on('input', () => {
                const thisVal = $(selector).val();
                $(selector2).val(thisVal);
            })
        }
        // end function when change inputs top cooment and sugg and run this ti table under top






        // start when click add button change content modal from edit to add 
        $('.right-content .add').click(function(e){
            $("#add_rate #top_section").slideDown();
            $("#add_rate #estimate_table").slideUp();  
            $('#estimate_table table tbody tr').remove();

        });
        // end when click add button change content modal from edit to add 







        
        // start when change groups tto get students to make estimate
        $("#Eval_GroupID").on('change', () =>{
            $(".dataInput_top").val('');
            if($("#Eval_GroupID").val()){

                $.ajax({
                    url: `{{ url('students_estimates/getStudentsToEstimate') }}/${$("#Eval_GroupID").val()}`,
                    type: 'GET',
                    beforeSend:function () {
                        $(".sum-input").css('border', '');
                        $('#estimate_table table tbody tr').remove();
                    },
                    success: function(res){
                        $("#estimate_table").slideDown();

                        if(res.length > 0){
                            $.each(res , function(index, value){
                                $('#estimate_table table tbody').append(`
                                    <tr>
                                        <td>${index+1}</td>
                                        <td style="font-size: 13px;font-weight: bold;">
                                            ${value.studentName} ${value.parentName}
                                            <input type="hidden" value="${value.studentId}" name="Eval_StudentID[]"/>
                                            <input type="hidden" value="${value.matId}" name="Eval_Years_Mat"/>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control dataInput Eval_Att Eval_Att_${index} sum-input focused" placeholder="10" min="0" name="Eval_Att[]">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control dataInput Eval_Part Eval_Part_${index} sum-input focused" placeholder="10" min="0" name="Eval_Part[]">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control dataInput Eval_Eval Eval_Eval_${index} sum-input focused" placeholder="40" min="0" name="Eval_Eval[]">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control dataInput Eval_HW Eval_HW_${index} sum-input focused" placeholder="40" min="0" name="Eval_HW[]">
                                        </td>
                                        <td>
                                            <input type="number" readonly class="form-control dataInput Eval_Degree" placeholder="0" name="Eval_Degree[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control dataInput Eval_TeacherComment" placeholder="تعليق المدرس" name="Eval_TeacherComment[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control dataInput Eval_TeacherSugg" placeholder="ملاحظات المدرس" name="Eval_TeacherSugg[]">
                                        </td>
                                    </tr>
                                `);
                            });
                        }else{
                            $("#estimate_table").css('display', 'none');
                            alertify.set('notifier','position', 'top-center');
                            alertify.set('notifier','delay', 3);
                            alertify.error("لايوجد طلبة تم اسنادها لهذة المجموعة");
                        }   

                        // focused Input
                        focusedInput();

                        // top inputs
                        chechIfValueBiggerThan('#Eval_Att_top', 0, 10);
                        chechIfValueBiggerThan('#Eval_Part_top', 0, 10);
                        chechIfValueBiggerThan('#Eval_Eval_top', 0, 40);
                        chechIfValueBiggerThan('#Eval_HW_top', 0, 40);
                        
                        // bottom inputs
                        chechIfValueBiggerThan('.Eval_Att', 0, 10);
                        chechIfValueBiggerThan('.Eval_Part', 0, 10);
                        chechIfValueBiggerThan('.Eval_Eval', 0, 40);
                        chechIfValueBiggerThan('.Eval_HW', 0, 40);

                        // changeInputsTop
                        changeInputsTop('#Eval_Att_top', '.Eval_Att', 10);
                        changeInputsTop('#Eval_Part_top', '.Eval_Part', 10);
                        changeInputsTop('#Eval_Eval_top', '.Eval_Eval', 40);
                        changeInputsTop('#Eval_HW_top', '.Eval_HW', 40);
                
                        // changeInputsTopCommAndSugg
                        changeInputsTopCommAndSugg('#Eval_TeacherComment_top', '.Eval_TeacherComment');
                        changeInputsTopCommAndSugg('#Eval_TeacherSugg_top', '.Eval_TeacherSugg');

                        // sumRow
                        sumRow();
                    }
                });

            }else{
                $("#estimate_table").slideUp();
                $('#estimate_table table tbody tr').remove();
            }
        });
    // start when change groups tto get students to make estimate






    // start when click save estimate button check if inputs null or not
    
    // end when click save estimate button check if inputs null or not

        
    </script>



    <script>
        $(document).ready(function () {
            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ url('/students_estimates/datatable') }}`,
                dataType: 'json',
                columns: [
                    {data: 'action', name: 'action', orderable: false},
                    {data: 'GroupName', name: 'GroupName'},
                    {data: 'teacherName', name: 'teacherName'},
                    {data: 'TheFullName', name: 'TheFullName'},
                    {data: 'Eval_Month', name: 'Eval_Month'},
                    {data: 'Eval_Year', name: '	Eval_Year'},
                    {data: 'Eval_Date', name: '	Eval_Date'},
                ],
                "bDestroy": true,
                language: {sUrl: '{{ asset("back/assets/js/ar_dt.json") }}'},
                lengthMenu: [[50, 100, -1], [50, 100, "الكل"]]
            });
        });
    </script>





    {{-- add, edit, delete => script --}}
    @include('back.students_rates.add')
    @include('back.students_rates.show')
    @include('back.students_rates.edit')
    @include('back.students_rates.delete')
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
            @if (auth()->user()->user_status === 4)
                <div class="d-flex my-xl-auto right-content">
                    <div class="pr-1 mb-xl-0">
                        <button type="button" class="btn btn-danger btn-icon ml-2 add" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter"><i class="mdi mdi-plus"></i></button>
                    </div>
                </div>                
            @endif
        </div>
        <!-- breadcrumb -->

        @include('back.students_rates.form')
        @include('back.students_rates.show_form')
        
        {{-- style="display: none;" --}}
        <div class="row row-sm" id="table">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="" style="overflow: auto;">
                            <table class="table table-bordered table-striped table-hover text-center text-nowrap" id="example1">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="border-bottom-0">التحكم</th>
                                        <th class="border-bottom-0">المجموعة</th>
                                        <th class="border-bottom-0">المدرس</th>
                                        <th class="border-bottom-0">المادة</th>
                                        <th class="border-bottom-0">الشهر</th>
                                        <th class="border-bottom-0">السنة</th>
                                        <th class="border-bottom-0">ت  التقييم</th>
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

