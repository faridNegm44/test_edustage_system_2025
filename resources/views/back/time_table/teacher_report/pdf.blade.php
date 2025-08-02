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
            width: 50%;
            padding: 10px;
            margin: 10px auto 20px;
            box-shadow: 7px 7px 5px 0px rgb(182 182 182 / 75%);
            font-weight: bold;
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

        <div>
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
                        <td>{{ $teacherDetails[0]->teacherId }}</td>
                        <td style="font-weight: bold;font-size: 18px;">{{ $teacherDetails[0]->teacherName }}</td>
                        <td>{{ $teacherDetails[0]->teacherEmail }}</td>
                        <td>{{ $teacherDetails[0]->teacherPhone1 }} {{ $teacherDetails[0]->teacherPhone2 == null ? '' : '/ '.$teacherDetails[0]->teacherPhone2  }}</td>
                        <td style="font-weight: bold;font-size: 18px;" id="count_groups"></td>
                    </tr>
                </tbody>
            </table>
        </div>
            
        <hr />

        @if (count($teacherDetails) > 0)
            <div>
                <table class="table table-bordered table-striped table-hover" id="table_res" style="font-size: 12px;"> 
                    <thead style="font-weight: bold;">
                        <tr>
                            <td class="text-center" style="font-weight: bold;"><strong>اسم الجروب</strong></td>
                            <td class="text-center" style="font-weight: bold;"><strong>من / إلي</strong></td>
                            <td class="text-center" style="font-weight: bold;"><strong>اليوم</strong></td>
                            <td class="text-center" style="font-weight: bold;"><strong>نوع الحصة</strong></td>
                            <td class="text-center" style="font-weight: bold;"><strong>الغرفة الدراسية</strong></td>
                            <td class="text-center" style="font-weight: bold;"><strong> الإضافة</strong></td>
                            <td class="text-center" style="font-weight: bold;"><strong>ملاحظات</strong></td>
                        </tr>
                    </thead>
                    
                    <tbody style="font-size: 11px;">
                        @foreach ($teacherDetails as $teacher)
                            @if ($teacher->group_id != null)
                                <tr>
                                    <td class="text-center" style="font-weight: bold;">{{ $teacher->groupName }}</td>
                                    <td class="text-center">{{ $teacher->from_to }}</td>
                                    <td class="text-center">{{ $teacher->day }}</td>                  
                                    <td class="text-center">
                                        @if ($teacher->class_type == 'أساسية')
                                            {{ $teacher->class_type }}
                                        @else
                                            <p>{{ $teacher->class_type }}</p>
                                            {{ $teacher->date }}
                                        @endif
                                    </td>                  
                                    <td class="text-center">
                                        <p>غرفة: {{ $teacher->roomName }}</p>
                                        مسختدم: {{ $teacher->user }}                            
                                    </td> 
                                    <td class="text-center">
                                        <p>{{ \Carbon\Carbon::parse($teacher->created_at)->format('Y-m-d') }}</p>    
                                        {{ \Carbon\Carbon::parse($teacher->created_at)->format('h:i a') }}
                                    </td>          
                                    <td class="text-center">{{ $teacher->notes }}</td>
                                </tr>    
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
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