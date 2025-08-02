<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        {{ $nameAr }}
        - من: {{ $start }}
        - الي: {{ $end }}
        - {{ date('d-m-Y') }} - {{ date('h:i a') }}
    </title>

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
                    <br />
                    من: {{ $start }}
                    - الي: {{ $end }}
                </h4>
            </div>
            <hr>

            @include('back.layouts.header_report')
        </div>

        <div>
            <table class="table table-bordered table-striped text-center" style="font-size: 12px;">
                <thead class="">
                    <tr>
                        <th class="text-center" style="width: 33.3%;">اجمالي الجروبات التي تم تقييمها</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: bold;font-size: 20px;">{{ count($groupsRated) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <hr />
        <div>
            <table class="table table-bordered table-striped table-hover" style="font-size: 12px;">
                <thead style="font-weight: bold;">
                    <tr>
                        <td class="text-center" style="font-weight: bold;"><strong>كود الجروب</strong></td>
                        <td class="text-center" style="font-weight: bold;"><strong>اسم الجروب</strong></td>
                        <td class="text-center" style="font-weight: bold;"><strong>المدرس</strong></td>
                        <td class="text-center" style="font-weight: bold;"><strong>المادة</strong></td>
                        <td class="text-center" style="font-weight: bold;"><strong>تاريخ التقييم</strong></td>
                    </tr>
                </thead>

                <tbody style="font-size: 11px;">
                    @foreach ($groupsRated as $group)
                        <tr>
                            <td class="text-center">{{ $group->groupId }}</td>
                            <td class="text-center">{{ $group->groupName }}</td>
                            <td class="text-center">{{ $group->teacherName }}</td>
                            <td class="text-center">{{ $group->matName }}</td>
                            <td class="text-center">{{ $group->Eval_Date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <hr>
        @include('back.layouts.footer_report')

    </div>
</body>
</html>
