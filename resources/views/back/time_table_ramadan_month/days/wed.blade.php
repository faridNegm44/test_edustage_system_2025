<div class="panel panel-default mb-4" id="Wednesday">
    <div class="panel-heading1 {{ $todayName == 'Wednesday' ? 'bg-success' : 'bg-secondary' }} ">
        <h4 class="panel-title1">
            <a class="{{ $todayName == 'Wednesday' ? 'accordion-toggle' : 'accordion-toggle collapsed' }}" data-toggle="collapse" data-parent="#accordion11" href="#wedAccord" aria-expanded="false">جدول الأربعاء</a>
        </h4>
    </div>

    <div id="wedAccord" class="{{ $todayName == 'Wednesday' ? 'panel-collapse collapse show' : 'panel-collapse collapse' }}" role="tabpanel" aria-expanded="true" style="">
        <div class="panel-body border">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-wrapper">
                        <table class="table table-bordered table-hover text-center text-md-nowrap" id="wedDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="background: #364261;color: #fff;max-width: 40px;min-width: 40px;padding: 0 !important;">م</th>
                                    @foreach ($times as $time)
                                        <th data-column_id="{{ $time->id }}" style="font-size: 10px !important;min-width: 25px;max-width: 25px;padding: 0 !important;">{{ $time->time }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($rooms as $room)  {{-- start loop to rooms  --}}
                                    <tr>
                                        <th class="first_column" style="background: #364261;color: #fff;font-size: 10px !important;padding: 0 !important;">
                                            <span style="font-size: 16px;color: #fff;font-weight: bold;position: relative;top: 3px;left: 5px;">*</span>
                                            <span>{{ $room->roomName }}</span>
                                        </th>

                                        {{-- start loop to times  --}}
                                        @foreach ($times as $time)

                                            @php $printedTime = false; @endphp

                                            @foreach ($wedClassesUserOne as $wedOne)
                                                @if ($room->roomId == $wedOne->room_id)

                                                    @if (($time->time.'-'.$time->am_pm) == $wedOne->times)
                                                    <th

                                                        @if ($wedOne->class_type == 'تعوضية')
                                                            style="background: white;color: red;border: 3px solid red;"
                                                        @elseif ($wedOne->class_type == 'محجوزة')
                                                            style="background: black;color: red;border: 3px solid red;"
                                                        @else
                                                            style="background: {{ $wedOne->matColor }};color: #222;"
                                                        @endif


                                                        data-group_id="{{ $wedOne->group_id }}"
                                                        data-group_to_colspan="{{ $wedOne->group_to_colspan }}"
                                                        class="myTooltip" data-html="true" data-placement="top"  data-toggle="tooltip"
                                                        title="
                                                            {{ $wedOne->from_to }}
                                                            <br />
                                                            {{ $wedOne->teacherName }}
                                                            @if($wedOne->date != null)
                                                                <br />
                                                                التاريخ: {{ $wedOne->date }}
                                                            @endif

                                                            @if($wedOne->notes != null)
                                                                <br />
                                                                ملاحظة: {{ $wedOne->notes }}
                                                            @endif
                                                        "

                                                        data-title="{{ $wedOne->groupName }}"
                                                        data-count_colspan="{{ App\Models\Back\TimeTableRamadanMonth::where('group_to_colspan', $wedOne->group_to_colspan)->count() }}"

                                                    >
                                                            {{ $wedOne->groupName }}
                                                        </th>
                                                        @php $printedTime = true; @endphp
                                                        @break
                                                    @endif

                                                @endif
                                            @endforeach {{-- end @foreach ($wedClassesUserOne as $wedOne) --}}

                                            @if (!$printedTime)
                                                <th data-column_id_tbody="{{ $time->id }}"></th>
                                            @endif

                                        @endforeach
                                        {{-- end loop to times  --}}
                                    </tr>






                                    {{-- //////////////////////////////////////////////////  user 2  ///////////////////////////////////////////////////// --}}
                                    {{-- //////////////////////////////////////////////////  user 2  ///////////////////////////////////////////////////// --}}




                                    <tr>
                                        <th class="first_column" style="background: #c25710;color: #ffffff96;max-width: 40px;min-width: 40px;font-size: 10px !important;padding: 0 !important;">
                                            <span style="font-size: 14px;color: #fff;font-weight: bold;position: relative;top: 1px;left: 5px;">#</span>
                                            <span>{{ $room->roomName }}</span>
                                        </th>

                                        {{-- start loop to times  --}}
                                        @foreach ($times as $time)

                                        @php $printedTime = false; @endphp

                                            @foreach ($wedClassesUserTwo as $wedTwo)
                                                @if ($room->roomId == $wedTwo->room_id)

                                                    @if (($time->time.'-'.$time->am_pm) == $wedTwo->times)
                                                    <th

                                                        @if ($wedTwo->class_type == 'تعوضية')
                                                            style="background: white;color: red;border: 3px solid red;"
                                                        @elseif ($wedTwo->class_type == 'محجوزة')
                                                            style="background: black;color: red;border: 3px solid red;"
                                                        @else
                                                            style="background: {{ $wedTwo->matColor }};color: #222;"
                                                        @endif

                                                        data-group_id="{{ $wedTwo->group_id }}"
                                                        data-group_to_colspan="{{ $wedTwo->group_to_colspan }}"
                                                        class="myTooltip" data-html="true" data-placement="top"  data-toggle="tooltip"
                                                        title="
                                                            {{ $wedTwo->from_to }}
                                                            <br />
                                                            {{ $wedTwo->teacherName }}
                                                            @if($wedTwo->date != null)
                                                                <br />
                                                                التاريخ: {{ $wedTwo->date }}
                                                            @endif

                                                            @if($wedTwo->notes != null)
                                                                <br />
                                                                ملاحظة: {{ $wedTwo->notes }}
                                                            @endif
                                                        "

                                                        data-title="{{ $wedTwo->groupName }}"
                                                        data-count_colspan="{{ App\Models\Back\TimeTableRamadanMonth::where('group_to_colspan', $wedTwo->group_to_colspan)->count() }}"

                                                    >
                                                            {{ $wedTwo->groupName }}
                                                        </th>
                                                        @php $printedTime = true; @endphp
                                                        @break
                                                    @endif

                                                @endif
                                            @endforeach {{-- end @foreach ($wedClassesUserOne as $wedTwo) --}}

                                            @if (!$printedTime)
                                                <th data-column_id_tbody="{{ $time->id }}"></th>
                                            @endif

                                        @endforeach
                                        {{-- end loop to times  --}}

                                    </tr>
                                @endforeach {{-- end loop to rooms  --}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
