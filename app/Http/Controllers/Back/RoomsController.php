<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Rooms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class RoomsController extends Controller
{
    public function index()
    {                
        $pageNameAr = 'الغرف الدراسية';
        $pageNameEn = 'rooms';
        
        return view('back.rooms.index' , compact('pageNameAr' , 'pageNameEn'));
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'RoomName' => 'required|string|max:50|unique:tbl_rooms,RoomName',
                'RoomUser' => 'required|string',
                'RoomPass' => 'required',
                'status' => 'required|integer',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'RoomName' => 'اسم الغرفة الدراسية',
                'RoomUser' => 'اسم المستخدم',
                'RoomPass' => 'كلمة السر',
                'status' => 'الحالة',
            ]);

            $data = request()->except('_token');
            $data['created_at'] = Carbon::now();
            $data['academic_year'] = GetAcademicYaer();

            Rooms::insert($data);
        }
    }

    public function edit($id)
    {
        if(request()->ajax()){
            $find = Rooms::where('RoomID', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'RoomName' => 'required|string|max:50|unique:tbl_rooms,RoomName,'.$id.',RoomID',
                'RoomUser' => 'required|string',
                'RoomPass' => 'required',
                'status' => 'required|integer',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'RoomName' => 'اسم الغرفة الدراسية',
                'RoomUser' => 'اسم المستخدم',
                'RoomPass' => 'كلمة السر',
                'status' => 'الحالة',
            ]);

            $data = request()->except('_token');
            $data['updated_at'] = Carbon::now();

            Rooms::where('RoomID', $id)->update($data);
        }
    }

    public function datatable()
    {
        $all = Rooms::leftJoin('academic_years', 'academic_years.id', 'tbl_rooms.academic_year')
                    ->select('academic_years.name as academicYearName', 'tbl_rooms.*')
                    ->get();

        return DataTables::of($all)
            ->addColumn('RoomID', function($res){
                return $res->RoomID;
            })      
            ->addColumn('RoomName', function($res){
                return $res->RoomName;
            })      
            ->addColumn('RoomUser', function($res){
                return $res->RoomUser;
            })      
            ->addColumn('RoomPass', function($res){
                return $res->RoomPass;
            })
            ->addColumn('status', function($res){
                if($res->status == 1){
                    return '<span class="label text-success" style="position: relative;"><div class="dot-label bg-success ml-1" style="position: absolute;right: -17px;top: 7px;"></div>نشط</span>';
                }
                else{
                    return '<span class="label text-danger" style="position: relative;"><div class="dot-label bg-danger ml-1" style="position: absolute;right: -15px;top: 7px;"></div>معطل</span>';
                }
            }) 
            ->addColumn('action', function($res){
                return '
                    <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="'.$res->RoomID.'">
                        <i class="fas fa-marker"></i>
                    </button>
                ';
            })
            ->rawColumns(['RoomID', 'RoomName', 'RoomPass', 'RoomUser', 'status', 'action'])
            ->toJson();
    }
}
