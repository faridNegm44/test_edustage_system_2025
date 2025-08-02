<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\TimeTableHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class TimeTableHistoryController extends Controller
{
    public function index()
    {                      
        $pageNameAr = 'سجل جدول الحصص';
        $pageNameEn = 'time_table_history';
        return view('back.time_table_history.index' , compact('pageNameAr' , 'pageNameEn'));
    }

    public function lastOrderNumber($id)
    {                
        $lastOrderNumber = TimeTableHistory::where('category', $id)->orderBy('order', 'desc')->first();
        if(!$lastOrderNumber){
            $lastOrderNumber = 1;
        }else{
            $lastOrderNumber = ($lastOrderNumber->order+1);
        }
        return response()->json($lastOrderNumber);
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'category' => 'required',
                'name_ar' => 'required|unique:time_table_history,name_ar',
            ],[
                'required' => ':attribute مطلوب.',
                'integer' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
            ],[
                'name_ar' => 'الإسم',
                'category' => 'التصنيف',
            ]);

            TimeTableHistory::create($request->all());
        }
    }

    public function edit($id)
    {
        if(request()->ajax()){
            $find = TimeTableHistory::where('id', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $find = TimeTableHistory::where('id', $id)->first();
        // dd($request->all());
            $this->validate($request , [
                'category' => 'required',
                'name_ar' => 'required|unique:time_table_history,name_ar,'.$id,
            ],[
                'required' => ':attribute مطلوب.',
                'integer' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدممن قبل.',
            ],[
                'name_ar' => 'الإسم بالعربية',
                'category' => 'التصنيف',
            ]);

            
            $find->update($request->all());
        }
    }

     
    public function destroy($id)
    {
        if(request()->ajax()){
            $find = TimeTableHistory::where('id', $id)->first();
            $find->delete();
        }
        return view('back.welcome');
    }


    public function datatable()
    {
        $all = TimeTableHistory::orderBy('id', 'desc')
                                ->leftJoin('tbl_groups', 'tbl_groups.ID', 'time_table_histories.group_id_time')
                                ->leftJoin('tbl_rooms', 'tbl_rooms.RoomID', 'time_table_histories.room_id_time')
                                ->leftJoin('users', 'users.id', 'time_table_histories.user_id')
                                ->select(
                                        "time_table_histories.*", 
                                        "tbl_groups.GroupName as groupName",
                                        "tbl_rooms.RoomName as roomName",
                                        "users.name as userName",
                                    )
                                // ->groupBy('time_tables.group_to_colspan')
                                ->get();


        return DataTables::of($all)
            ->addColumn('group_id_time', function($res){
                return $res->groupName;
            })      
            ->addColumn('type_history', function($res){
                if($res->type_history == 'اضافة حصة'){
                    return "<span class='badge badge-success text-white' style='font-size: 10px;padding: 3px 5px;'>".$res->type_history."</span>";
                }elseif($res->type_history == 'تعديل حصة'){
                    return "<span class='badge badge-secondary text-white' style='font-size: 10px;padding: 3px 5px;'>".$res->type_history."</span>";
                }elseif($res->type_history == 'حذف جزئي'){
                    return "<span class='badge badge-warning text-white' style='font-size: 10px;padding: 3px 5px;'>".$res->type_history."</span>";
                }elseif($res->type_history == 'حذف كلي'){
                    return "<span class='badge badge-danger text-white' style='font-size: 10px;padding: 3px 5px;'>".$res->type_history."</span>";
                }
                return $res->type_history;
            })      
            ->addColumn('class_type_time', function($res){
                if($res->class_type_time == 'تعوضية'){
                    return 
                            $res->class_type_time . '<br>' .
                            Carbon::parse($res->date_time)->format('Y-m-d')
                            .' <span style="color: red;"> '.Carbon::parse($res->date_time)->format('h:i:s a').'</span>';
                }else{
                    return $res->class_type_time;
                }
            })      
            ->addColumn('user_id', function($res){
                return 
                        $res->userName . '<br>' .
                        Carbon::parse($res->created_at)->format('Y-m-d')
                        .' <span style="font-weight: bold;margin: 0 7px;">'.Carbon::parse($res->created_at)->format('h:i:s a').'</span>';
            })      
            ->addColumn('room_user', function($res){
                return 'غرفة '.$res->roomName . '<br>' . 'مستخدم '.$res->user_room;
            })      
            ->addColumn('times', function($res){
                if($res->type_history != 'حذف كلي' && $res->type_history != 'حذف جزئي'){
                    $times = explode(',', $res->times);
                    $firstTime = Arr::first($times);
                    $lastTime = Arr::last($times);
    
                    return 'من '.$firstTime . '<br>' . 'الي ' . $lastTime;
                }else{
                    return $res->times;   
                }
            })      
            ->addColumn('day_time', function($res){
                return $res->day_time;
            })      
            ->addColumn('notes_time', function($res){
                return $res->notes_time;
            })      
            ->rawColumns(['group_id_time', 'type_history', 'class_type_time', 'user_id', 'room_user', 'times', 'day_time', 'notes_time'])
            ->toJson();
    }
}