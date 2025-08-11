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
        
        @media print {
            tr:nth-child(even) {background-color: #f2f2f2 !important;-webkit-print-color-adjust: exact;}
            tr:nth-child(odd) {background-color: #ffffff !important;-webkit-print-color-adjust: exact;}
            tr.gray {background-color: #d8d8d8 !important;-webkit-print-color-adjust: exact;}
            th, td {font-size: 10px !important;padding: 2px 2px !important;}
            .table > tbody > tr {height: 18px !important;}
            .table thead tr th{color: #000 !important; font-weight: bold !important;font-size: 14px !important;}
            #user_name {color: red !important;}
            .globe{color: #007bff !important;}
            .facebook{color: #065dce !important;}
            .youtube{color: red !important;}
            .whatsapp{color: green !important;}
        }
    </style>
</head>
<body style=" background-color: #f9f9f9;">
    <div style="padding: 20px; background-color: #fff; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="border: 2px solid #dee2e6; padding: 10px; border-radius: 10px; margin-bottom: 10px;">
            <h4 class="text-center" style="font-weight: bold; color: #343a40; margin: 0;">
                🧾 {{ $pageNameAr }} - <span style="color: red;" id="user_name">{{ $results[0]->TheName0 }}</span>
            </h4>
        </div>

        @include('back.layouts.header_report')


        @if($from || $to)
            <div style="border: 1px solid #2196f3; background: #e3f2fd; border-radius: 6px; padding: 8px 15px; margin-bottom: 15px;">
                {{--<strong>عناصر البحث:</strong>--}}
                {{--<span style="margin: 0px 10px;">@if($teacher_id) مدرس: {{ $results[0]->TheName0 }} @endif</span>--}}
                <span style="margin: 0px 10px;">@if($from) من: {{ $from }} @endif</span>
                <span style="margin: 0px 10px;">@if($to) إلى: {{ $to }} @endif</span>
            </div>
        @endif

        <div>
            <table class="" style="width:100%; text-align:center; font-size:11px; background-color: #fff; border-collapse:collapse;">
                <thead style="background-color: #e9ecef; font-weight: bold;border-bottom: 1px solid #b4b4b4;">
                    <tr style="height:28px;">
                        <th style="vertical-align: middle; padding:2px 4px;">تاريخ الدفعة</th>
                        <th style="vertical-align: middle; padding:2px 4px;">طريقة الدفع</th>
                        <th style="vertical-align: middle; padding:2px 4px;">المبلغ</th>
                        <th style="vertical-align: middle; padding:2px 4px;width: 50% !important;">ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($results as $result)
                        <tr style="height:22px;font-size:16px;">
                            <td style="padding:2px 4px;">
                                <span>{{ Carbon\Carbon::parse($result->TheDate)->format('d-m-Y') }}</span>
                            </td>
                            <td style="padding:2px 4px;">{{ $result->ThePayType }}</td>
                            <td style="padding:2px 4px;">
                                <span style="font-weight:bold; color:#007bff;">
                                    {{ display_number($result->amount_by_currency) }}
                                </span>
                            </td>
                            <td style="padding:2px 4px;">{{ $result->admin_notes }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="color:#888; padding:6px 0;">لا توجد بيانات لعرضها</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="summary">
            <!-- العمود الأيسر -->
            <div class="col">
                <h3>💰 المدفوعات</h3>
                <table>
                    <tr>
                        <td>إجمالي مدفوعات سابقة</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>إجمالي مدفوعات الفترة المحددة</td>
                        <td>108,000.00</td>
                    </tr>
                    <tr>
                        <td>إجمالي المدفوعات</td>
                        <td>108,000.00 ج.م</td>
                    </tr>
                </table>
            </div>
        
            <!-- العمود الأيمن -->
            <div class="col">
                <h3>🏷️ الخصومات</h3>
                <table>
                    <tr>
                        <td>إجمالي خصومات سابقة</td>
                        <td>1,690.00</td>
                    </tr>
                    <tr>
                        <td>إجمالي خصومات الفترة المحددة</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>إجمالي الخصومات</td>
                        <td>1,690.00 ج.م</td>
                    </tr>
                </table>
            </div>
        </div>

        @include('back.layouts.footer_report')
        {{--<script> window.print(); </script>--}}
    </div>
</body>
</html>
