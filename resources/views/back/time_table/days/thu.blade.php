<div class="panel panel-default mb-4" id="Thursday">
    <div class="panel-heading1 {{ $todayName == 'Thursday' ? 'bg-success' : 'bg-secondary' }} ">
        <h4 class="panel-title1">
            <a class="{{ $todayName == 'Thursday' ? 'accordion-toggle' : 'accordion-toggle collapsed' }}" data-toggle="collapse" data-parent="#accordion11" href="#thuAccord" aria-expanded="false">جدول الخميس</a>
        </h4>
    </div>

    <div id="thuAccord" class="{{ $todayName == 'Thursday' ? 'panel-collapse collapse show' : 'panel-collapse collapse' }}" role="tabpanel" aria-expanded="true" style="">
        <div class="panel-body border">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-wrapper">
                        <table class="table table-bordered table-hover text-center text-md-nowrap" id="thuDataTable">
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

                                            @foreach ($thuClassesUserOne as $thuOne)
                                                @if ($room->roomId == $thuOne->room_id)

                                                    @if (($time->time.'-'.$time->am_pm) == $thuOne->times)
                                                    <th

                                                        @if ($thuOne->class_type == 'تعوضية')
                                                            style="background: white;color: red;border: 3px solid red;"
                                                        @elseif ($thuOne->class_type == 'محجوزة')
                                                            style="background: black;color: red;border: 3px solid red;"
                                                        @else
                                                            style="background: {{ $thuOne->matColor }};color: #222;"
                                                        @endif


                                                        data-group_id="{{ $thuOne->group_id }}"
                                                        data-group_to_colspan="{{ $thuOne->group_to_colspan }}"
                                                        class="myTooltip" data-html="true" data-placement="top"  data-toggle="tooltip"
                                                        title="
                                                            {{ $thuOne->from_to }}
                                                            <br />
                                                            {{ $thuOne->teacherName }}
                                                            @if($thuOne->date != null)
                                                                <br />
                                                                التاريخ: {{ $thuOne->date }}
                                                            @endif

                                                            @if($thuOne->notes != null)
                                                                <br />
                                                                ملاحظة: {{ $thuOne->notes }}
                                                            @endif
                                                        "

                                                        data-title="{{ $thuOne->groupName }}"
                                                        data-count_colspan="{{ App\Models\Back\TimeTable::where('group_to_colspan', $thuOne->group_to_colspan)->count() }}"

                                                    >
                                                            {{ $thuOne->groupName }}
                                                        </th>
                                                        @php $printedTime = true; @endphp
                                                        @break
                                                    @endif

                                                @endif
                                            @endforeach {{-- end @foreach ($thuClassesUserOne as $thuOne) --}}

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

                                            @foreach ($thuClassesUserTwo as $thuTwo)
                                                @if ($room->roomId == $thuTwo->room_id)

                                                    @if (($time->time.'-'.$time->am_pm) == $thuTwo->times)
                                                    <th

                                                        @if ($thuTwo->class_type == 'تعوضية')
                                                            style="background: white;color: red;border: 3px solid red;"
                                                        @elseif ($thuTwo->class_type == 'محجوزة')
                                                            style="background: black;color: red;border: 3px solid red;"
                                                        @else
                                                            style="background: {{ $thuTwo->matColor }};color: #222;"
                                                        @endif

                                                        data-group_id="{{ $thuTwo->group_id }}"
                                                        data-group_to_colspan="{{ $thuTwo->group_to_colspan }}"
                                                        class="myTooltip" data-html="true" data-placement="top"  data-toggle="tooltip"
                                                        title="
                                                            {{ $thuTwo->from_to }}
                                                            <br />
                                                            {{ $thuTwo->teacherName }}
                                                            @if($thuTwo->date != null)
                                                                <br />
                                                                التاريخ: {{ $thuTwo->date }}
                                                            @endif

                                                            @if($thuTwo->notes != null)
                                                                <br />
                                                                ملاحظة: {{ $thuTwo->notes }}
                                                            @endif
                                                        "

                                                        data-title="{{ $thuTwo->groupName }}"
                                                        data-count_colspan="{{ App\Models\Back\TimeTable::where('group_to_colspan', $thuTwo->group_to_colspan)->count() }}"

                                                    >
                                                            {{ $thuTwo->groupName }}
                                                        </th>
                                                        @php $printedTime = true; @endphp
                                                        @break
                                                    @endif

                                                @endif
                                            @endforeach {{-- end @foreach ($thuClassesUserOne as $thuTwo) --}}

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
