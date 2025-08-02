<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\Back\TimeTable;
use App\Models\Back\TimeTableHistory;
use App\Models\Back\Times;
use Illuminate\Support\Facades\Cache;

class TimeTableController extends Controller
{

    public function __construct()
    {
        ini_set('memory_limit', '1G');
    }

    public function daysClasses($dayAr, $userNum){
        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){   // start check if auth()->user()->user_status == 1 || 2  => admin or employ
            return DB::table('time_tables')
                    ->where('day', $dayAr)
                    ->where('user', $userNum)
                    ->leftJoin('tbl_groups', 'tbl_groups.ID', 'time_tables.group_id')
                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                    ->leftJoin('tbl_rooms', 'tbl_rooms.RoomID', 'time_tables.room_id')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_groups.TeacherID')
                    ->select(
                        'time_tables.*',
                        'tbl_groups.GroupName as groupName',
                        'tbl_years_mat.TheColor as matColor',
                        'tbl_teachers.ID as teacherId',
                        'tbl_teachers.TheName as teacherName',
                        'tbl_rooms.RoomName as roomName',
                    )
                    ->orderBy('time_tables.room_id', 'ASC')
                    ->get();
        }   // end check if auth()->user()->user_status == 1 || 2  => admin or employ

        elseif(auth()->user()->user_status == 4){   // start check if auth()->user()->user_status == 4 => teacher
            return DB::table('time_tables')
                    ->where('day', $dayAr)
                    ->where('user', $userNum)
                    ->leftJoin('tbl_groups', 'tbl_groups.ID', 'time_tables.group_id')
                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                    ->leftJoin('tbl_rooms', 'tbl_rooms.RoomID', 'time_tables.room_id')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_groups.TeacherID')
                    // ->leftJoin('users', 'users.id', 'tbl_teachers.UserID')
                    ->select(
                        'time_tables.*',
                        'tbl_groups.GroupName as groupName',
                        'tbl_years_mat.TheColor as matColor',
                        'tbl_teachers.ID as teacherId',
                        'tbl_teachers.UserID as teacherUserID',
                        'tbl_teachers.TheName as teacherName',
                        'tbl_rooms.RoomName as roomName',
                    )
                    ->where('tbl_teachers.UserID', auth()->user()->id)
                    ->orderBy('time_tables.room_id', 'ASC')
                    ->get();
        } // end check if auth()->user()->user_status == 4 => teacher
    }

    public function index()
    {
        // dd($dates_before_today);

        // $currentYear =   date(now()->year.'-9-1');
        // $nextYear = date(now()->addYear()->year.'-8-31');

        $pageNameAr = 'جدول الحصص للمدرسين';
        $pageNameEn = 'time_table';


        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){   // start check if auth()->user()->user_status == 1 || 2  => admin or employ
            $groups = DB::table('tbl_groups')
                    // ->whereBetween('OpenDate', [$currentYear, $nextYear])
                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_groups.TeacherID')
                    ->select(
                        'tbl_groups.ID as groupId',
                        'tbl_groups.TeacherID as teacherId',
                        'tbl_groups.GroupName as groupName',

                        'tbl_years_mat.TheFullName as matName',
                        'tbl_years_mat.TheColor as matColor',

                        'tbl_teachers.TheName as teacherName',
                    )
                    ->distinct('tbl_groups.YearID')
                    ->orderBy('tbl_teachers.TheName', 'ASC')
                    ->get();

        }  // end check if auth()->user()->user_status == 1 || 2  => admin or employ

        elseif(auth()->user()->user_status == 4){   // start check if auth()->user()->user_status == 4 => teacher
            $groups = DB::table('tbl_groups')
                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_groups.TeacherID')
                    ->select(
                        'tbl_groups.ID as groupId',
                        'tbl_groups.TeacherID as teacherId',
                        'tbl_groups.GroupName as groupName',
                        'tbl_years_mat.TheFullName as matName',
                        'tbl_years_mat.TheColor as matColor',
                        'tbl_teachers.TheName as teacherName',
                    )
                    ->where('tbl_teachers.UserID', auth()->user()->id)
                    ->distinct('tbl_groups.YearID')
                    ->orderBy('tbl_teachers.TheName', 'ASC')
                    ->get();
        } // end check if auth()->user()->user_status == 4 => teacher

        // return $groups;


        $rooms = Cache::remember('rooms_data', 60, function() {
            return DB::table('tbl_rooms')
                        ->select('tbl_rooms.RoomID as roomId', 'tbl_rooms.RoomName as roomName')
                        ->orderBy('tbl_rooms.RoomName', 'asc')
                        ->get();
        });

        $times = Times::orderBy('am_pm', 'asc')
                        ->orderBy('order', 'asc')
                        // ->select('time')
                        ->get();


        $satClassesUserOne = $this->daysClasses('السبت', 1);
        $satClassesUserTwo = $this->daysClasses('السبت', 2);

        $sunClassesUserOne = $this->daysClasses('الأحد', 1);
        $sunClassesUserTwo = $this->daysClasses('الأحد', 2);

        $monClassesUserOne = $this->daysClasses('الاثنين', 1);
        $monClassesUserTwo = $this->daysClasses('الاثنين', 2);

        $tueClassesUserOne = $this->daysClasses('الثلاثاء', 1);
        $tueClassesUserTwo = $this->daysClasses('الثلاثاء', 2);

        $wedClassesUserOne = $this->daysClasses('الأربعاء', 1);
        $wedClassesUserTwo = $this->daysClasses('الأربعاء', 2);

        $thuClassesUserOne = $this->daysClasses('الخميس', 1);
        $thuClassesUserTwo = $this->daysClasses('الخميس', 2);

        $friClassesUserOne = $this->daysClasses('الجمعة', 1);
        $friClassesUserTwo = $this->daysClasses('الجمعة', 2);



        //return $satClassesUserOne;

        // return
        //    $satClassesUserOne. '---' .
        //    $satClassesUserTwo. '---' .
        //    $sunClassesUserOne. '---' .
        //    $sunClassesUserTwo. '---' .
        //    $monClassesUserOne. '---' .
        //    $monClassesUserTwo. '---' .
        //    $tueClassesUserOne. '---' .
        //    $tueClassesUserTwo. '---' .
        //    $wedClassesUserOne. '---' .
        //    $wedClassesUserTwo. '---' .
        //    $thuClassesUserOne. '---' .
        //    $thuClassesUserTwo. '---' .
        //    $friClassesUserOne. '---' .
        //    $friClassesUserTwo
        // ;

        return view('back.time_table.index' , compact('pageNameAr' , 'pageNameEn', 'groups', 'rooms', 'times', 'satClassesUserOne', 'satClassesUserTwo', 'sunClassesUserOne', 'sunClassesUserTwo', 'monClassesUserOne', 'monClassesUserTwo', 'tueClassesUserOne', 'tueClassesUserTwo', 'wedClassesUserOne', 'wedClassesUserTwo', 'thuClassesUserOne', 'thuClassesUserTwo', 'friClassesUserOne', 'friClassesUserTwo'));
    }

    public function get_available_times_to_add_form(Request $request)
    {
        $timesToTimeTable = DB::table('time_tables')
                                ->where('day', request('day'))
                                ->where('room_id', request('room_id'))
                                ->where('user', request('user'))
                                ->get();

        $times = Times::orderBy('am_pm', 'asc')->orderBy('order', 'asc')->get();

        return response()->json([
            'timesToTimeTable' => $timesToTimeTable,
            'times' => $times,
        ]);
    }

    public function get_available_times_to_edit_form(Request $request)
    {
        $timesToTimeTable = DB::table('time_tables')
                                ->where('day', request('day'))
                                ->where('room_id', request('room_id'))
                                ->where('user', request('user'))
                                ->get();

        $times = Times::orderBy('am_pm', 'asc')->orderBy('order', 'asc')->get();

        return response()->json([
            'timesToTimeTable' => $timesToTimeTable,
            'times' => $times,
        ]);
    }


    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'group_id' => 'required',
                'times' => 'required',
                'date' => auth()->user()->user_status == 4
                            ? 'required|date|after_or_equal:today'
                            : (request('class_type') == 'تعوضية' ? 'required|date|after_or_equal:today' : 'nullable'),
            ],[
                'required' => ':attribute مطلوب.',
                'after_or_equal' => ':attribute يجب أن يكون اليوم أو بعده.',
            ],[
                'group_id' => 'إختيار المجموعة',
                'times' => 'إختيار وقت واحد ع الأقل',
                'date' => 'تاريخ الحصة التعوضية',
            ]);




            if(auth()->user()->user_status == 4){  // start check لو المستخدم الي مسجل مدرس

                $dayName = Carbon::parse(request('date'))->locale('ar')->translatedFormat('l');
                $isEqual = $dayName == request('day');

                if($isEqual){
                    DB::transaction(function(){
                        $timesReq = request('times');
                        $firstTimeReq = reset($timesReq);
                        $lastTimeReq = end($timesReq);

                        $lastId = $this->getLastId('time_tables', 'group_to_colspan');

                        for($i = 0; $i < count(request('times')); $i++){
                            $data[] = [
                                'group_id' => request('group_id'),
                                'notes' => request('notes'),
                                'date' => request('date'),
                                'day' => request('day'),
                                'class_type' => 'تعوضية',
                                'times' => request('times')[$i],
                                'from_to' => $firstTimeReq.' - '.$lastTimeReq,
                                'room_id' => request('room_id'),
                                'user' => request('user'),
                                'group_to_colspan' => $lastId,
                                'created_at' => Carbon::now(),
                            ];
                        }
                        TimeTable::insert($data);

                        TimeTableHistory::create([
                            'user_id' => auth()->user()->id,
                            'type_history' => 'اضافة حصة',
                            'relation_id' => $lastId,
                            'times' => implode(',', request('times')),
                            'group_id_time' => request('group_id'),
                            'class_type_time' => 'تعوضية',
                            'day_time' => request('day'),
                            'date_time' => request('date'),
                            'room_id_time' => request('room_id'),
                            'user_room' => request('user'),
                            'notes_time' => request('notes'),
                            'created_at' => Carbon::now(),
                        ]);

                    });
                }else{
                    return response()->json(['daysNotEqual' => 'error']);
                }

            }else{  // else check لو المستخدم الي مسجل أدمن او موظف


                // start check لو في قيمه class type تساوي حصه تعوضية
                if(request('class_type') == 'تعوضية'){
                    $dayName = Carbon::parse(request('date'))->locale('ar')->translatedFormat('l');
                    $isEqual = $dayName == request('day');

                    if($isEqual){
                        DB::transaction(function(){
                            $timesReq = request('times');
                            $firstTimeReq = reset($timesReq);
                            $lastTimeReq = end($timesReq);

                            $lastId = $this->getLastId('time_tables', 'group_to_colspan');

                            for($i = 0; $i < count(request('times')); $i++){
                                $data[] = [
                                    'group_id' => request('group_id'),
                                    'notes' => request('notes'),
                                    'date' => request('date'),
                                    'day' => request('day'),
                                    'class_type' => request('class_type'),
                                    'times' => request('times')[$i],
                                    'from_to' => $firstTimeReq.' - '.$lastTimeReq,
                                    'room_id' => request('room_id'),
                                    'user' => request('user'),
                                    'group_to_colspan' => $lastId,
                                    'created_at' => Carbon::now(),
                                ];
                            }
                            TimeTable::insert($data);

                            TimeTableHistory::create([
                                'user_id' => auth()->user()->id,
                                'type_history' => 'اضافة حصة',
                                'relation_id' => $lastId,
                                'times' => implode(',', request('times')),
                                'group_id_time' => request('group_id'),
                                'class_type_time' => request('class_type'),
                                'day_time' => request('day'),
                                'date_time' => request('date'),
                                'room_id_time' => request('room_id'),
                                'user_room' => request('user'),
                                'notes_time' => request('notes'),
                                'created_at' => Carbon::now(),
                            ]);

                        });
                    }else{
                        return response()->json(['daysNotEqual' => 'error']);
                    }


                }else{   // else check لو في قيمه class type حصه اساسيه أو محجوزه

                    DB::transaction(function(){
                        $timesReq = request('times');
                        $firstTimeReq = reset($timesReq);
                        $lastTimeReq = end($timesReq);

                        $lastId = $this->getLastId('time_tables', 'group_to_colspan');

                        for($i = 0; $i < count(request('times')); $i++){
                            $data[] = [
                                'group_id' => request('group_id'),
                                'notes' => request('notes'),
                                'date' => !request()->has('date') ? null : request('date'),
                                'day' => request('day'),
                                'class_type' => request('class_type'),
                                'times' => request('times')[$i],
                                'from_to' => $firstTimeReq.' - '.$lastTimeReq,
                                'room_id' => request('room_id'),
                                'user' => request('user'),
                                'group_to_colspan' => $lastId,
                                'created_at' => Carbon::now(),
                            ];
                        }
                        TimeTable::insert($data);

                        TimeTableHistory::create([
                            'user_id' => auth()->user()->id,
                            'type_history' => 'اضافة حصة',
                            'relation_id' => $lastId,
                            'times' => implode(',', request('times')),
                            'group_id_time' => request('group_id'),
                            'class_type_time' => request('class_type'),
                            'day_time' => request('day'),
                            'date_time' => request('date'),
                            'room_id_time' => request('room_id'),
                            'user_room' => request('user'),
                            'notes_time' => request('notes'),
                            'created_at' => Carbon::now(),
                        ]);

                    });
                }
                // end check لو في قيمه class type تساوي حصه تعوضية
            }


        }
    }


    public function update(Request $request, $group_to_colspan)
    {
        if (request()->ajax()){

            if(!request('times')){
                $this->validate($request , [
                    'group_id' => 'required',
                ],[
                    'required' => ':attribute مطلوب.',
                ],[
                    'group_id' => 'إختيار المجموعة',
                ]);

                DB::transaction(function() use ($group_to_colspan) {
                    $findHistory = TimeTableHistory::where('relation_id', $group_to_colspan)->first();

                    TimeTable::where('group_to_colspan', $group_to_colspan)->update([
                        'class_type' => request('class_type'),
                        'notes' => request('notes'),
                        'updated_at' => Carbon::now(),
                    ]);

                    TimeTableHistory::create([
                        'user_id' => auth()->user()->id,
                        'type_history' => 'تعديل حصة',
                        'relation_id' => $findHistory->relation_id,
                        'times' => $findHistory->times,
                        'group_id_time' => $findHistory->group_id_time,
                        'day_time' => $findHistory->day_time,
                        'date_time' => $findHistory->date_time,
                        'room_id_time' => $findHistory->room_id_time,
                        'user_room' => $findHistory->user_room,
                        'class_type_time' => request('class_type'),
                        'notes_time' => request('notes'),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                });

            }else{
                $this->validate($request , [
                    'group_id' => 'required',
                    'times' => 'required',
                ],[
                    'required' => ':attribute مطلوب.',
                ],[
                    'group_id' => 'إختيار المجموعة',
                    'times' => 'إختيار وقت واحد ع الأقل',
                ]);

                DB::transaction(function(){
                    $timesReq = request('times');
                    $firstTimeReq = reset($timesReq);
                    $lastTimeReq = end($timesReq);

                    $lastId = $this->getLastId('time_tables', 'group_to_colspan');

                    for($i = 0; $i < count(request('times')); $i++){
                        $data[] = [
                            'group_id' => request('group_id'),
                            'notes' => request('notes'),
                            'date' => !request()->has('date') ? null : request('date'),
                            'day' => request('day'),
                            'class_type' => request('class_type'),
                            'times' => request('times')[$i],
                            'from_to' => $firstTimeReq.' - '.$lastTimeReq,
                            'room_id' => request('room_id'),
                            'user' => request('user'),
                            'group_to_colspan' => $lastId,
                            'created_at' => Carbon::now(),
                        ];
                    }
                    TimeTable::insert($data);

                    TimeTableHistory::create([
                        'user_id' => auth()->user()->id,
                        'type_history' => 'اضافة حصة بعد حذف',
                        'relation_id' => $lastId,
                        'times' => implode(',', request('times')),
                        'group_id_time' => request('group_id'),
                        'class_type_time' => request('class_type'),
                        'day_time' => request('day'),
                        'date_time' => request('date'),
                        'room_id_time' => request('room_id'),
                        'user_room' => request('user'),
                        'notes_time' => request('notes'),
                        'created_at' => Carbon::now(),
                    ]);
                }); // end DB::transaction
            }

        } // end request()->ajax()
    }

    public function edit($group_id, $group_to_colspan)
    {
        if (request()->ajax()){
            $findTimesTimeTable = TimeTable::where('group_id', $group_id)
                                            ->where('group_to_colspan', $group_to_colspan)
                                            ->leftJoin('tbl_groups', 'tbl_groups.ID', 'time_tables.group_id')
                                            ->leftJoin('tbl_rooms', 'tbl_rooms.RoomID', 'time_tables.room_id')
                                            ->select(
                                                'time_tables.*',
                                                'tbl_groups.GroupName as groupName',
                                                'tbl_rooms.RoomName as roomName',
                                            )
                                            ->get();


            $plukTimes = TimeTable::where('group_id', $group_id)->where('group_to_colspan', $group_to_colspan)->pluck('times')->toArray();
            $implodePlukTimes = implode(',', $plukTimes);

            $timesToTimeTable = DB::table('time_tables')
                                            ->where('day', request('day'))
                                            ->where('room_id', request('room_id'))
                                            ->where('user', request('user'))
                                            ->get();

            $times = Times::orderBy('am_pm', 'asc')->orderBy('order', 'asc')->get();

            return response()->json([
                'findTimesTimeTable' => $findTimesTimeTable,
                'implodePlukTimes' => $implodePlukTimes,
                'timesToTimeTable' => $timesToTimeTable,
                'times' => $times,
            ]);
        }
        return response()->json(['failed' => 'Access Denied']);
    }


    public function remove_recorded_times(Request $request){
        $values = request('values');
        $texts = request('texts');
        $notes = request('notes');

        $getInfoFirst = TimeTable::where('id', $values[0])->first();
        $getInfoAllCount = TimeTable::where('group_to_colspan', $getInfoFirst->group_to_colspan)->count();


        DB::transaction(function() use ($values, $texts, $getInfoFirst, $getInfoAllCount, $notes){

            TimeTableHistory::create([
                'user_id' => auth()->user()->id,
                'type_history' => count($values) == $getInfoAllCount ? 'حذف كلي' :  'حذف جزئي',
                'relation_id' => $getInfoFirst->group_to_colspan,
                'times' => implode(',', $texts),
                'group_id_time' => $getInfoFirst->group_id,
                'day_time' => $getInfoFirst->day,
                'date_time' => $getInfoFirst->date,
                'room_id_time' => $getInfoFirst->room_id,
                'user_room' => $getInfoFirst->user,
                'class_type_time' => $getInfoFirst->class_type,
                'notes_time' => $notes,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            TimeTable::whereIn('id', $values)->delete();

            $firstRow = TimeTable::where('group_to_colspan', $getInfoFirst->group_to_colspan)->orderBy('id', 'asc')->first();
            $latestRow = TimeTable::where('group_to_colspan', $getInfoFirst->group_to_colspan)->orderBy('id', 'desc')->first();

            if($firstRow && $latestRow){
                TimeTable::where('group_to_colspan', $getInfoFirst->group_to_colspan)
                        ->update([
                            'from_to' => $firstRow->times.' - '.$latestRow->times,
                        ]);
            }
        });
    }



    // navbar_search_in_time_table
    public function navbar_search_in_time_table(Request $request){
        $search = request('search');

        $groups = DB::table('tbl_groups')
                    ->where('GroupName', 'like', '%' . $search . '%')
                    ->leftJoin('time_tables', 'time_tables.group_id', 'tbl_groups.ID')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_groups.TeacherID')
                    ->leftJoin('tbl_rooms', 'tbl_rooms.RoomID', 'time_tables.room_id')
                    ->select(
                        'time_tables.*',
                        'tbl_groups.GroupName as groupName',
                        'tbl_teachers.ID as teacherId',
                        'tbl_teachers.TheName as teacherName',
                        'tbl_rooms.RoomName as roomName',
                    )
                    ->orderBy('tbl_teachers.TheName', 'ASC')
                    ->groupBy('time_tables.group_to_colspan')
                    ->get();

                    // dd($groups);

        return response()->json(['groups' =>  $groups]);
    }
}

