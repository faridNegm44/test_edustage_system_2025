<div class="panel panel-default mb-4" id="Friday">
    <div class="panel-heading1 {{ $todayName == 'Friday' ? 'bg-success' : 'bg-secondary' }} ">
        <h4 class="panel-title1">
            <a class="{{ $todayName == 'Friday' ? 'accordion-toggle' : 'accordion-toggle collapsed' }}" data-toggle="collapse" data-parent="#accordion11" href="#friAccord" aria-expanded="false">جدول الجمعة</a>
        </h4>
    </div>

    <div id="friAccord" class="{{ $todayName == 'Friday' ? 'panel-collapse collapse show' : 'panel-collapse collapse' }}" role="tabpanel" aria-expanded="true" style="">
        <div class="panel-body border">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-wrapper">
                        <table class="table table-bordered table-hover text-center text-md-nowrap" id="friDataTable">
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

                                            @foreach ($friClassesUserOne as $friOne)
                                                @if ($room->roomId == $friOne->room_id)

                                                    @if (($time->time.'-'.$time->am_pm) == $friOne->times)
                                                    <th

                                                        @if ($friOne->class_type == 'تعوضية')
                                                            style="background: white;color: red;border: 3px solid red;"
                                                        @elseif ($friOne->class_type == 'محجوزة')
                                                            style="background: black;color: red;border: 3px solid red;"
                                                        @else
                                                            style="background: {{ $friOne->matColor }};color: #222;"
                                                        @endif


                                                        data-group_id="{{ $friOne->group_id }}"
                                                        data-group_to_colspan="{{ $friOne->group_to_colspan }}"
                                                        class="myTooltip" data-html="true" data-placement="top"  data-toggle="tooltip"
                                                        title="
                                                            {{ $friOne->from_to }}
                                                            <br />
                                                            {{ $friOne->teacherName }}
                                                            @if($friOne->date != null)
                                                                <br />
                                                                التاريخ: {{ $friOne->date }}
                                                            @endif

                                                            @if($friOne->notes != null)
                                                                <br />
                                                                ملاحظة: {{ $friOne->notes }}
                                                            @endif
                                                        "

                                                        data-title="{{ $friOne->groupName }}"
                                                        data-count_colspan="{{ App\Models\Back\TimeTableRamadanMonth::where('group_to_colspan', $friOne->group_to_colspan)->count() }}"

                                                    >
                                                            {{ $friOne->groupName }}
                                                        </th>
                                                        @php $printedTime = true; @endphp
                                                        @break
                                                    @endif

                                                @endif
                                            @endforeach {{-- end @foreach ($friClassesUserOne as $friOne) --}}

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

                                            @foreach ($friClassesUserTwo as $friTwo)
                                                @if ($room->roomId == $friTwo->room_id)

                                                    @if (($time->time.'-'.$time->am_pm) == $friTwo->times)
                                                    <th

                                                        @if ($friTwo->class_type == 'تعوضية')
                                                            style="background: white;color: red;border: 3px solid red;"
                                                        @elseif ($friTwo->class_type == 'محجوزة')
                                                            style="background: black;color: red;border: 3px solid red;"
                                                        @else
                                                            style="background: {{ $friTwo->matColor }};color: #222;"
                                                        @endif

                                                        data-group_id="{{ $friTwo->group_id }}"
                                                        data-group_to_colspan="{{ $friTwo->group_to_colspan }}"
                                                        class="myTooltip" data-html="true" data-placement="top"  data-toggle="tooltip"
                                                        title="
                                                            {{ $friTwo->from_to }}
                                                            <br />
                                                            {{ $friTwo->teacherName }}
                                                            @if($friTwo->date != null)
                                                                <br />
                                                                التاريخ: {{ $friTwo->date }}
                                                            @endif

                                                            @if($friTwo->notes != null)
                                                                <br />
                                                                ملاحظة: {{ $friTwo->notes }}
                                                            @endif
                                                        "

                                                        data-title="{{ $friTwo->groupName }}"
                                                        data-count_colspan="{{ App\Models\Back\TimeTableRamadanMonth::where('group_to_colspan', $friTwo->group_to_colspan)->count() }}"

                                                    >
                                                            {{ $friTwo->groupName }}
                                                        </th>
                                                        @php $printedTime = true; @endphp
                                                        @break
                                                    @endif

                                                @endif
                                            @endforeach {{-- end @foreach ($friClassesUserOne as $friTwo) --}}

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
