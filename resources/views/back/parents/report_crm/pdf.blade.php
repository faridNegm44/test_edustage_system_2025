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
                        <th class="text-center">اسم ولي الأمر</th>
                        <th class="text-center">البريد الإلكتروني</th>
                        <th class="text-center">أرقام التليفونات</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $parentDetails->ID }}</td>
                        <td style="font-weight: bold;font-size: 18px;">{{ $parentDetails->TheName0 }}</td>
                        <td>{{ $parentDetails->TheEmail }}</td>
                        <td>{{ $parentDetails->ThePhone1 }} {{ $parentDetails->ThePhone2 == null ? '' : '/ '.$parentDetails->ThePhone2  }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <hr />
        <div class="">
            <h3 class="text-center heading_table">بيانات الأبناء</h3>
            <table class="table table-bordered table-striped table-hover" style="font-size: 12px;">
                <thead style="font-weight: bold;">
                    <tr>
                        <td class="text-center" style="font-weight: bold;width: 15%;"><strong>اسم الطالب</strong></td>
                        <td class="text-center" style="font-weight: bold;width: 15%;"><strong>الصف/المادة</strong></td>
                        {{--  <td class="text-center" style="font-weight: bold;width: 30%;"><strong>نظام التعليم</strong></td>  --}}
                        <td class="text-center" style="font-weight: bold;"><strong>نظام الامتحانات</strong></td>
                        <td class="text-center" style="font-weight: bold;width: 15%;"><strong>اسم الجروب</strong></td>
                        <td class="text-center" style="font-weight: bold;"><strong>اسم المدرس</strong></td>
                    </tr>
                </thead>

                <tbody style="font-size: 11px;">
                    @foreach ($studentDetails as $student)
                        <tr>
                            <td class="text-center">{{ $student->studentName }}</td>
                            <td class="text-center">{{ $student->fullMatName }}</td>
                            {{--  <td class="text-center">{{ $student->eduType }}</td>  --}}
                            <td class="text-center">{{ $student->testType }}</td>
                            <td class="text-center">{{ $student->groupName }}</td>
                            <td class="text-center">{{ $student->teacherName }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



        <hr />
        <div class="">

            @foreach ($crmCategoriesDetails as $crmCategory)    {{-- start loop to crm category --}}
                <h3 class="text-center heading_table">{{ $crmCategory->name }}</h3>

                @foreach ($crmColumnsNamesDetails as $crmColumnName)    {{-- start loop to crm names --}}

                    @if ($crmCategory->id == $crmColumnName->category)  {{-- start check if crm category id == crm colum name->category --}}

                        <div style="padding: 5px 0;">
                            <label class="crmColumnName" style="text-decoration: underline;margin-left: 5px;">{{ $crmColumnName->name_ar }}: </label>

                            @foreach ($crmColumnsValues as $crmColumnValue)     {{-- start loop to crm values --}}
                                <span class="crmColumnValue">{{ $crmColumnName->id == $crmColumnValue->columnId ? $crmColumnValue->value : '' }}</span>
                            @endforeach     {{-- end loop to crm values --}}
                        </div>

                    @endif    {{-- end check if crm category id == crm colum name->category --}}

                @endforeach   {{-- end loop to crm names --}}

            @endforeach    {{-- end loop to crm category --}}
        </div>


        <hr>
        @include('back.layouts.footer_report')

    </div>
</body>
</html>
