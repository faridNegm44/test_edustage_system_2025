<div class="panel panel-default mb-4" id="Saturday">
    <div class="panel-heading1 {{ $todayName == 'Saturday' ? 'bg-success' : 'bg-secondary' }} ">
        <h4 class="panel-title1">
            <a class="{{ $todayName == 'Saturday' ? 'accordion-toggle' : 'accordion-toggle collapsed' }}" data-toggle="collapse" data-parent="#accordion11" href="#satAccord" aria-expanded="false">جدول السبت</a>
        </h4>
    </div>

    <div id="satAccord" class="{{ $todayName == 'Saturday' ? 'panel-collapse collapse show' : 'panel-collapse collapse' }}" role="tabpanel" aria-expanded="true" style="">
        <div class="panel-body border">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-wrapper">
                        <table class="table table-bordered table-hover text-center text-md-nowrap" id="satDataTable">
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

                                            @foreach ($satClassesUserOne as $satOne)
                                                @if ($room->roomId == $satOne->room_id)

                                                    @if (($time->time.'-'.$time->am_pm) == $satOne->times)
                                                    <th

                                                        @if ($satOne->class_type == 'تعوضية')
                                                            style="background: white;color: red;border: 3px solid red;"
                                                        @elseif ($satOne->class_type == 'محجوزة')
                                                            style="background: black;color: red;border: 3px solid red;"
                                                        @else
                                                            style="background: {{ $satOne->matColor }};color: #222;"
                                                        @endif

                                                        data-group_id="{{ $satOne->group_id }}"
                                                        data-group_to_colspan="{{ $satOne->group_to_colspan }}"
                                                        class="myTooltip" data-html="true" data-placement="top"  data-toggle="tooltip"
                                                        title="
                                                            {{ $satOne->from_to }}
                                                            <br />
                                                            {{ $satOne->teacherName }}
                                                            @if($satOne->date != null)
                                                                <br />
                                                                التاريخ: {{ $satOne->date }}
                                                            @endif
                                                            @if($satOne->notes != null)
                                                                <br />
                                                                ملاحظة: {{ $satOne->notes }}
                                                            @endif
                                                        "
                                                        data-title="{{ $satOne->groupName }}"
                                                        data-count_colspan="{{ App\Models\Back\TimeTable::where('group_to_colspan', $satOne->group_to_colspan)->count() }}"

                                                    >
                                                            {{ $satOne->groupName }}
                                                        </th>
                                                        @php $printedTime = true; @endphp
                                                        @break
                                                    @endif

                                                @endif
                                            @endforeach {{-- end @foreach ($satClassesUserOne as $satOne) --}}

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

                                            @foreach ($satClassesUserTwo as $satTwo)
                                                @if ($room->roomId == $satTwo->room_id)

                                                    @if (($time->time.'-'.$time->am_pm) == $satTwo->times)
                                                    <th

                                                        @if ($satTwo->class_type == 'تعوضية')
                                                            style="background: white;color: red;border: 3px solid red;"
                                                        @elseif ($satTwo->class_type == 'محجوزة')
                                                            style="background: black;color: red;border: 3px solid red;"
                                                        @else
                                                            style="background: {{ $satTwo->matColor }};color: #222;"
                                                        @endif

                                                        data-group_id="{{ $satTwo->group_id }}"
                                                        data-group_to_colspan="{{ $satTwo->group_to_colspan }}"
                                                        class="myTooltip" data-html="true" data-placement="top"  data-toggle="tooltip"
                                                        title="
                                                            {{ $satTwo->from_to }}
                                                            <br />
                                                            {{ $satTwo->teacherName }}
                                                            @if($satTwo->date != null)
                                                                <br />
                                                                التاريخ: {{ $satTwo->date }}
                                                            @endif
                                                            @if($satTwo->notes != null)
                                                                <br />
                                                                ملاحظة: {{ $satTwo->notes }}
                                                            @endif
                                                        "

                                                        data-title="{{ $satTwo->groupName }}"
                                                        data-count_colspan="{{ App\Models\Back\TimeTable::where('group_to_colspan', $satTwo->group_to_colspan)->count() }}"

                                                    >
                                                            {{ $satTwo->groupName }}
                                                        </th>
                                                        @php $printedTime = true; @endphp
                                                        @break
                                                    @endif

                                                @endif
                                            @endforeach {{-- end @foreach ($satClassesUserOne as $satTwo) --}}

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
