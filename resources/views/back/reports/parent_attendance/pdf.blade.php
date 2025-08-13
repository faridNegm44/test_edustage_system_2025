<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $pageNameAr }} - {{ $results[0]->TheName0 }} - {{ date('d-m-Y') }} - {{ date('h:i a') }}</title>

    <link rel="icon" href="{{ asset('back') }}/assets/img/brand/favicon.png" type="image/x-icon"/>

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        .table > thead > tr > th, .table > tbody > tr > td {border: 1px solid #bbb !important;}
        .table > tbody > tr {height: 22px !important;}

        th, td{text-align: center;padding: 1px;font-size: 14px;font-weight: bold;padding: 2px 4px !important;vertical-align: middle !important;}

        .itemsSearch{margin: 0 10px;}
        .summary {display: flex;justify-content: space-between;border: 1px solid #ccc;padding: 10px;font-family: Arial, sans-serif;font-size: 14px;margin-top: 10px;}
        .summary .col {width: 48%;}
        .summary h3 {font-weight: bold;padding: 5px;font-size: 15px;margin: 0 0 5px;text-align: center;}
        .summary table {width: 100%; border-collapse: collapse;}
        .summary table td {padding: 5px;border-bottom: 1px solid #eee;}
        .summary table td:last-child {text-align: right; font-weight: bold;}
        #total {display: flex; justify-content: center; align-items: center;padding: 18px 0 5px;border: 1px solid #adadad;background-color: #e9ecef !important;}

        @media print {
            tr:nth-child(even) {background-color: #f2f2f2 !important;-webkit-print-color-adjust: exact;}
            tr:nth-child(odd) {background-color: #ffffff !important;-webkit-print-color-adjust: exact;}
            tr.gray {background-color: #d8d8d8 !important;-webkit-print-color-adjust: exact;}
            th, td {font-size: 10px !important;padding: 2px 2px !important;}
            .table > tbody > tr {height: 18px !important;}
            .table thead tr th{color: #000 !important; font-weight: bold !important;font-size: 14px !important;}
            .globe{color: #007bff !important;}
            .facebook{color: #065dce !important;}
            .youtube{color: red !important;}
            .whatsapp{color: green !important;}
            #total{ background-color: #e9ecef !important;-webkit-print-color-adjust: exact; }
            .red_color{ color: red !important;-webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body style=" background-color: #f9f9f9;">
    <div style="padding: 20px; background-color: #fff; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="border: 2px solid #dee2e6; padding: 10px; border-radius: 10px; margin-bottom: 10px;">
            <h4 class="text-center" style="font-weight: bold; color: #343a40; margin: 0;">
                🧾 {{ $pageNameAr }} - <span class="red_color" style="color: red;" id="user_name">{{ $results[0]->TheName0 }}</span>
            </h4>
        </div>

        @include('back.layouts.header_report')


        @if($from || $to)
            <div style="border: 1px solid #2196f3; background: #e3f2fd; border-radius: 6px; padding: 8px 15px; margin-bottom: 15px;">
                {{--<span style="margin: 0px 10px;">@if($teacher_id) مدرس: {{ $results[0]->TheName0 }} @endif</span>--}}
                <span style="margin: 0px 10px;">@if($from) من: {{ $from }} @endif</span>
                <span style="margin: 0px 10px;">@if($to) إلى: {{ $to }} @endif</span>
            </div>
        @endif


        @php $groupData = $results->groupBy('studentName'); @endphp
        @foreach ($groupData as $studentName => $studentResults)
            <div style="margin-bottom: 15px;">
                <h3 class="text-center" style="font-weight: bold;text-decoration: underline;">الطالب: 
                    <span class="red_color" style="color: red;">{{ $studentName }}</span>
                </h3>
                
                <table class="table-bordered table-hover" style="width:100%; text-align:center; font-size:11px; background-color: #fff; border-collapse:collapse;margin-bottom: 20px;">
                    <thead style="background-color: #e9ecef; font-weight: bold;border-bottom: 1px solid #b4b4b4;">
                        <tr style="height:28px;">
                            <th style="vertical-align: middle; padding:2px 4px;width: 20% !important;">الصف والمادة</th>
                            <th style="vertical-align: middle; padding:2px 4px;width: 20% !important;">المجموعة</th>
                            <th style="vertical-align: middle; padding:2px 4px;width: 20% !important;">المدرس</th>
                            <th style="vertical-align: middle; padding:2px 4px;width: 10% !important;">رقم الحصة</th>
                            <th style="vertical-align: middle; padding:2px 4px;width: 20% !important;">تاريخ الحصة</th>
                            <th style="vertical-align: middle; padding:2px 4px;width: 20% !important;">الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalAll = 0; // إجمالي الحصص
                            $totalAttendance = 0; // حاضر
                            $totalAbsence = 0; //غائب
                            $totalPaidAbsence = 0; // غائب/مدفوع
                        @endphp
                        @forelse ($studentResults as $result)
                            @php
                                $totalAll++;
                                if ($result->attendanceStatus == 'حاضر') {
                                    $totalAttendance++;
                                } elseif ($result->attendanceStatus == 'غائب') {
                                    $totalAbsence++;
                                } elseif ($result->attendanceStatus == 'غائب/مدفوع') {
                                    $totalPaidAbsence++;
                                }
                            @endphp
                            <tr style="height:22px;font-size:16px;">
                                <td style="padding:2px 4px;">{{ $result->matName }}</td>
                                <td style="padding:2px 4px;">{{ $result->groupName }}</td>
                                <td style="padding:2px 4px;">
                                    <span style="font-weight:bold; color:#007bff;">
                                        {{ $result->teacherName }}
                                    </span>
                                </td>
                                <td style="padding:2px 4px;">{{ $result->classNumber }}</td>
                                <td style="padding:2px 4px;">
                                    <span>{{ Carbon\Carbon::parse($result->classDate)->format('d-m-Y') }}</span>
                                </td>
                                <td style="padding:2px 4px;">{{ $result->attendanceStatus }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="color:#888; padding:6px 0;">لا توجد بيانات لعرضها</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div id="total">
                    <p style="font-weight: bold;">
                        إجمالي عدد الحصص: <span class="red_color" style="color: red;">{{ $totalAll }}</span>
                    </p>
                    <ul style="list-style: none; padding: 0;">
                        <li style="display: inline-block; margin-right: 20px;">
                            <span>الحضور</span>: 
                            <span style="font-weight: bold;">{{ $totalAttendance }}</span> 
                            <span style="margin-right: 5px;font-weight: bold;">(% {{ display_number( ($totalAttendance / $totalAll) * 100 ) }} )</span>
                        </li>
                        <li style="display: inline-block; margin-right: 20px;">
                            <span>الغياب</span>: 
                            <span style="font-weight: bold;">{{ $totalAbsence }}</span> 
                            <span style="margin-right: 5px;font-weight: bold;">(% {{ display_number( ($totalAbsence / $totalAll) * 100 ) }} )</span>
                        </li>
                        <li style="display: inline-block; margin-right: 20px;">
                            <span>غائب / مدفوع</span>: 
                            <span style="font-weight: bold;">{{ $totalPaidAbsence }}</span> 
                            <span style="margin-right: 5px;font-weight: bold;">(% {{ display_number( ($totalPaidAbsence / $totalAll) * 100 ) }} )</span>
                        </li>
                    </ul>
                </div>
            </div>
        @endforeach

        @include('back.layouts.footer_report')
        {{--<script> window.print(); </script>--}}
    </div>
</body>
</html>
