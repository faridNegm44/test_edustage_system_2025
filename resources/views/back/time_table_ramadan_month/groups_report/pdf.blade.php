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
                        <th class="text-center" style="width: 50%;">عدد الجروبات التي تم البحث عنها</th>
                        <th class="text-center" style="width: 50%;">عدد النتائج</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: bold;font-size: 18px;">{{ $countReqGroup }}</td>
                        <td style="font-weight: bold;font-size: 18px;">{{ count($groupsDetails) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <hr />
        @if ($groupsDetails[0]->group_id != null)
            <div>
                <table class="table table-bordered table-striped table-hover" style="font-size: 12px;"> 
                    <thead style="font-weight: bold;">
                        <tr>
                            <td class="text-center" style="font-weight: bold;"><strong>الجروب</strong></td>
                            <td class="text-center" style="font-weight: bold;"><strong>المدرس</strong></td>
                            <td class="text-center" style="font-weight: bold;"><strong>من / إلي</strong></td>
                            <td class="text-center" style="font-weight: bold;"><strong>اليوم</strong></td>
                            <td class="text-center" style="font-weight: bold;"><strong>نوع الحصة</strong></td>
                            <td class="text-center" style="font-weight: bold;"><strong>الغرفة الدراسية</strong></td>
                            <td class="text-center" style="font-weight: bold;"><strong>الإضافة</strong></td>
                            <td class="text-center" style="font-weight: bold;"><strong>ملاحظات</strong></td>
                        </tr>
                    </thead>
                    
                    <tbody style="font-size: 11px;">
                        @foreach ($groupsDetails as $group)
                            <tr>
                                <td class="text-center">{{ $group->groupName }}</td>
                                <td class="text-center">{{ $group->teacherName }}</td>
                                <td class="text-center">{{ $group->from_to }}</td>
                                <td class="text-center">{{ $group->day }}</td>                  
                                <td class="text-center">
                                    @if ($group->class_type == 'أساسية')
                                        {{ $group->class_type }}
                                    @else
                                        <p>{{ $group->class_type }}</p>
                                        {{ $group->date }}
                                    @endif
                                </td>                  
                                <td class="text-center">
                                    <p>غرفة: {{ $group->roomName }}</p>
                                    مسختدم: {{ $group->user }}                            
                                </td> 
                                <td class="text-center">
                                    <p>{{ \Carbon\Carbon::parse($group->created_at)->format('Y-m-d') }}</p>
                                    {{ \Carbon\Carbon::parse($group->created_at)->format('h:i a') }}
                                </td>          
                                <td class="text-center">{{ $group->notes }}</td>
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <h3 class="text-center" style="margin-top: 30px;font-weight: bold;">لايوجد حصص مسجلة</h3>            
        @endif
            
        <hr>
        @include('back.layouts.footer_report')

    </div>
</body>
</html>