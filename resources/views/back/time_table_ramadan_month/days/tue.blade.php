<div class="panel panel-default mb-4" id="Tuesday">
    <div class="panel-heading1 {{ $todayName == 'Tuesday' ? 'bg-success' : 'bg-secondary' }} ">
        <h4 class="panel-title1">
            <a class="{{ $todayName == 'Tuesday' ? 'accordion-toggle' : 'accordion-toggle collapsed' }}" data-toggle="collapse" data-parent="#accordion11" href="#tueAccord" aria-expanded="false">جدول الثلاثاء</a>
        </h4>
    </div>

    <div id="tueAccord" class="{{ $todayName == 'Tuesday' ? 'panel-collapse collapse show' : 'panel-collapse collapse' }}" role="tabpanel" aria-expanded="true" style="">
        <div class="panel-body border">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-wrapper">
                        <table class="table table-bordered table-hover text-center text-md-nowrap" id="tueDataTable">
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

                                            @foreach ($tueClassesUserOne as $tueOne)
                                                @if ($room->roomId == $tueOne->room_id)

                                                    @if (($time->time.'-'.$time->am_pm) == $tueOne->times)
                                                    <th

                                                        @if ($tueOne->class_type == 'تعوضية')
                                                            style="background: white;color: red;border: 3px solid red;"
                                                        @elseif ($tueOne->class_type == 'محجوزة')
                                                            style="background: black;color: red;border: 3px solid red;"
                                                        @else
                                                            style="background: {{ $tueOne->matColor }};color: #222;"
                                                        @endif


                                                        data-group_id="{{ $tueOne->group_id }}"
                                                        data-group_to_colspan="{{ $tueOne->group_to_colspan }}"
                                                        class="myTooltip" data-html="true" data-placement="top"  data-toggle="tooltip"
                                                        title="
                                                            {{ $tueOne->from_to }}
                                                            <br />
                                                            {{ $tueOne->teacherName }}
                                                            @if($tueOne->date != null)
                                                                <br />
                                                                التاريخ: {{ $tueOne->date }}
                                                            @endif
                                                            @if($tueOne->notes != null)
                                                                <br />
                                                                ملاحظة: {{ $tueOne->notes }}
                                                            @endif
                                                        "

                                                        data-title="{{ $tueOne->groupName }}"
                                                        data-count_colspan="{{ App\Models\Back\TimeTableRamadanMonth::where('group_to_colspan', $tueOne->group_to_colspan)->count() }}"

                                                    >
                                                            {{ $tueOne->groupName }}
                                                        </th>
                                                        @php $printedTime = true; @endphp
                                                        @break
                                                    @endif

                                                @endif
                                            @endforeach {{-- end @foreach ($tueClassesUserOne as $tueOne) --}}

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

                                            @foreach ($tueClassesUserTwo as $tueTwo)
                                                @if ($room->roomId == $tueTwo->room_id)

                                                    @if (($time->time.'-'.$time->am_pm) == $tueTwo->times)
                                                    <th

                                                        @if ($tueTwo->class_type == 'تعوضية')
                                                            style="background: white;color: red;border: 3px solid red;"
                                                        @elseif ($tueTwo->class_type == 'محجوزة')
                                                            style="background: black;color: red;border: 3px solid red;"
                                                        @else
                                                            style="background: {{ $tueTwo->matColor }};color: #222;"
                                                        @endif

                                                        data-group_id="{{ $tueTwo->group_id }}"
                                                        data-group_to_colspan="{{ $tueTwo->group_to_colspan }}"
                                                        class="myTooltip" data-html="true" data-placement="top"  data-toggle="tooltip"
                                                        title="
                                                            {{ $tueTwo->from_to }}
                                                            <br />
                                                            {{ $tueTwo->teacherName }}
                                                            @if($tueTwo->date != null)
                                                                <br />
                                                                التاريخ: {{ $tueTwo->date }}
                                                            @endif
                                                            @if($tueTwo->notes != null)
                                                                <br />
                                                                ملاحظة: {{ $tueTwo->notes }}
                                                            @endif
                                                        "

                                                        data-title="{{ $tueTwo->groupName }}"
                                                        data-count_colspan="{{ App\Models\Back\TimeTableRamadanMonth::where('group_to_colspan', $tueTwo->group_to_colspan)->count() }}"

                                                    >
                                                            {{ $tueTwo->groupName }}
                                                        </th>
                                                        @php $printedTime = true; @endphp
                                                        @break
                                                    @endif

                                                @endif
                                            @endforeach {{-- end @foreach ($tueClassesUserOne as $tueTwo) --}}

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
