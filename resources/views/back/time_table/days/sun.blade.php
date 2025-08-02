<div class="panel panel-default mb-4" id="Sunday">
    <div class="panel-heading1 {{ $todayName == 'Sunday' ? 'bg-success' : 'bg-secondary' }} ">
        <h4 class="panel-title1">
            <a class="{{ $todayName == 'Sunday' ? 'accordion-toggle' : 'accordion-toggle collapsed' }}" data-toggle="collapse" data-parent="#accordion11" href="#sunAccord" aria-expanded="false">جدول الأحد</a>
        </h4>
    </div>

    <div id="sunAccord" class="{{ $todayName == 'Sunday' ? 'panel-collapse collapse show' : 'panel-collapse collapse' }}" role="tabpanel" aria-expanded="true" style="">
        <div class="panel-body border">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-wrapper">
                        <table class="table table-bordered table-hover text-center text-md-nowrap" id="sunDataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="background: #364261;color: #fff;padding: 0 !important;">م</th>
                                    @foreach ($times as $time)
                                        <th data-column_id="{{ $time->id }}" style="font-size: 10px !important;min-width: 25px;max-width: 25px;padding: 0 !important;">{{ $time->time }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($rooms as $room)  {{-- start loop to rooms  --}}
                                    <tr>
                                        <th class="first_column" style="background: #364261;color: #fff;max-width: 40px;min-width: 40px;font-size: 10px !important;padding: 0 !important;">
                                            <span style="font-size: 16px;color: #fff;font-weight: bold;position: relative;top: 3px;left: 5px;">*</span>
                                            <span>{{ $room->roomName }}</span>
                                        </th>

                                        {{-- start loop to times  --}}
                                        @foreach ($times as $time)

                                            @php $printedTime = false; @endphp

                                            @foreach ($sunClassesUserOne as $sunOne)
                                                @if ($room->roomId == $sunOne->room_id)

                                                    @if (($time->time.'-'.$time->am_pm) == $sunOne->times)
                                                    <th

                                                        @if ($sunOne->class_type == 'تعوضية')
                                                            style="background: white;color: red;border: 3px solid red;"
                                                        @elseif ($sunOne->class_type == 'محجوزة')
                                                            style="background: black;color: red;border: 3px solid red;"
                                                        @else
                                                            style="background: {{ $sunOne->matColor }};color: #222;"
                                                        @endif


                                                        data-group_id="{{ $sunOne->group_id }}"
                                                        data-group_to_colspan="{{ $sunOne->group_to_colspan }}"
                                                        class="myTooltip" data-html="true" data-placement="top"  data-toggle="tooltip"
                                                        title="
                                                            {{ $sunOne->from_to }}
                                                            <br />
                                                            {{ $sunOne->teacherName }}
                                                            @if($sunOne->date != null)
                                                                <br />
                                                                التاريخ: {{ $sunOne->date }}
                                                            @endif
                                                            @if($sunOne->notes != null)
                                                                <br />
                                                                ملاحظة: {{ $sunOne->notes }}
                                                            @endif
                                                        "

                                                        data-title="{{ $sunOne->groupName }}"
                                                        data-count_colspan="{{ App\Models\Back\TimeTable::where('group_to_colspan', $sunOne->group_to_colspan)->count() }}"

                                                    >
                                                            {{ $sunOne->groupName }}
                                                        </th>
                                                        @php $printedTime = true; @endphp
                                                        @break
                                                    @endif

                                                @endif
                                            @endforeach {{-- end @foreach ($sunClassesUserOne as $sunOne) --}}

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

                                            @foreach ($sunClassesUserTwo as $sunTwo)
                                                @if ($room->roomId == $sunTwo->room_id)

                                                    @if (($time->time.'-'.$time->am_pm) == $sunTwo->times)
                                                    <th

                                                        @if ($sunTwo->class_type == 'تعوضية')
                                                            style="background: white;color: red;border: 3px solid red;"
                                                        @elseif ($sunTwo->class_type == 'محجوزة')
                                                            style="background: black;color: red;border: 3px solid red;"
                                                        @else
                                                            style="background: {{ $sunTwo->matColor }};color: #222;"
                                                        @endif

                                                        data-group_id="{{ $sunTwo->group_id }}"
                                                        data-group_to_colspan="{{ $sunTwo->group_to_colspan }}"
                                                        class="myTooltip" data-html="true" data-placement="top"  data-toggle="tooltip"
                                                        title="
                                                            {{ $sunTwo->from_to }}
                                                            <br />
                                                            {{ $sunTwo->teacherName }}
                                                            @if($sunTwo->date != null)
                                                                <br />
                                                                التاريخ: {{ $sunTwo->date }}
                                                            @endif
                                                            @if($sunTwo->notes != null)
                                                                <br />
                                                                ملاحظة: {{ $sunTwo->notes }}
                                                            @endif
                                                        "

                                                        data-title="{{ $sunTwo->groupName }}"
                                                        data-count_colspan="{{ App\Models\Back\TimeTable::where('group_to_colspan', $sunTwo->group_to_colspan)->count() }}"

                                                    >
                                                            {{ $sunTwo->groupName }}
                                                        </th>
                                                        @php $printedTime = true; @endphp
                                                        @break
                                                    @endif

                                                @endif
                                            @endforeach {{-- end @foreach ($sunClassesUserOne as $sunTwo) --}}

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
