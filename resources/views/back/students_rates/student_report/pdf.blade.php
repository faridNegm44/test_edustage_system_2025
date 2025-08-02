<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $nameAr }} - {{ date('d-m-Y') }} - {{ date('h:i a') }}</title>
    
    <link rel="icon" href="{{ url('back') }}/images/settings/fiv.png" type="image/x-icon"/>
    
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600&display=swap" rel="stylesheet">

    <style>
        .panel-default {
            border: 0;
        }
        .heading_table{
            border: 1px dotted;
            margin: 10px auto 20px;
            box-shadow: 7px 7px 5px 0px rgb(182 182 182 / 75%);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="">
            <div class="invoice-title">
                <h4 class="text-center" style="font-weight: bold;">
                    {{ $nameAr }}
                </h4>
            </div>
            <hr>
            
            @include('back.layouts.header_report')
        </div>

        {{--  <div>
            <table class="table table-bordered table-striped text-center" style="font-size: 12px;">
                <thead class="">
                    <tr>
                        <th class="text-center">كود</th>
                        <th class="text-center">اسم المدرس</th>
                        <th class="text-center">البريد الإلكتروني</th>
                        <th class="text-center">أرقام التليفونات</th>
                        <th class="text-center">عدد الجروبات</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $studentDetails[0]->studentId }}</td>
                        <td style="font-weight: bold;font-size: 18px;">{{ $studentDetails[0]->studentName }}</td>
                        <td>{{ $studentDetails[0]->studentEmail }}</td>
                        <td>{{ $studentDetails[0]->studentPhone1 }} {{ $studentDetails[0]->studentPhone2 == null ? '' : '/ '.$studentDetails[0]->studentPhone2  }}</td>
                        <td style="font-weight: bold;font-size: 18px;" id="count_groups"></td>
                    </tr>
                </tbody>
            </table>
        </div>  --}}
            
        <hr />

        @if (count($studentDetails) > 0)
            @foreach ($studentDetails as $student)
                <div>
                    <div class="text-center" style="font-size: 15px;">
                        <span style="margin-left: 15px;font-weight: bold;">مجموعة: {{ $student->groupName }}</span>    
                        <span style="margin-left: 15px;;font-weight: bold;">شهر: {{ $student->Eval_Month }}</span>    
                        <span style="margin-left: 15px;">سنة: {{ $student->Eval_Year }}</span>    
                        <span style="margin-left: 15px;">مدرس: {{ $student->teacherName }}</span>                  
                    </div>

                    <table class="table table-bordered table-striped table-hover" id="table_res" style="font-size: 12px;"> 
                        <thead style="font-weight: bold;">
                            <tr>
                                <td class="text-center" style="font-weight: bold;"><strong>تاريخ التقييم</strong></td>
                                <td class="text-center" style="font-weight: bold;"><strong>الحضور</strong></td>
                                <td class="text-center" style="font-weight: bold;"><strong>المشاركة</strong></td>
                                <td class="text-center" style="font-weight: bold;"><strong>الإختبارات</strong></td>
                                <td class="text-center" style="font-weight: bold;"><strong>الواجبات</strong></td>
                                <td class="text-center" style="font-weight: bold;"><strong> المجموع</strong></td>
                                <td class="text-center" style="font-weight: bold;"><strong>تعليق المدرس</strong></td>
                                <td class="text-center" style="font-weight: bold;"><strong>ملاحظات المدرس</strong></td>
                            </tr>
                        </thead>
                        
                        <tbody style="font-size: 11px;">
                            <tr>
                                <td class="text-center" style="font-weight: bold;">{{ $student->Eval_Date }}</td>
                                <td class="text-center">{{ $student->Eval_Att }}</td>
                                <td class="text-center">{{ $student->Eval_Part }}</td>                  
                                <td class="text-center">{{ $student->Eval_Eval }}</td>                  
                                <td class="text-center">{{ $student->Eval_HW }}</td>                  
                                <td class="text-center">{{ $student->Eval_Degree }}</td>                  
                                <td class="text-center">{{ $student->Eval_TeacherComment }}</td>                  
                                <td class="text-center">{{ $student->Eval_TeacherSugg }}</td>                  
                            </tr>    
                        </tbody>
                    </table>
                </div>
                <hr />
            @endforeach
        @else
            <h3 class="text-center" style="margin-top: 30px;font-weight: bold;">لايوجد حصص مسجلة</h3>            
        @endif
    
        <hr>
        @include('back.layouts.footer_report')


        <script>
            $(document).ready(function () {
                const count_groups = $("#table_res tbody tr").length;
                $("#count_groups").text(count_groups);
            });
        </script>
    </div>
</body>
</html>