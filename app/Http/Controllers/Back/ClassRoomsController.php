<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Rooms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ClassRoomsController extends Controller
{
    public function index()
    {                               
        $pageNameAr = 'الصفوف الدراسية';
        $pageNameEn = 'class_rooms';
        
        return view('back.class_rooms.index' , compact('pageNameAr' , 'pageNameEn'));
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'name' => 'required|string|max:50|unique:class_rooms,name',
                'status' => 'required|integer',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'name' => 'الصف الدراسي',
                'status' => 'الحالة',
            ]);

            $color = '';
            if((request('color2')) && (request('color'))){
                $color = request('color2');
                
            }elseif( request('color') ){
                $color = request('color');

            }

            DB::table('class_rooms')->insert([
                'name' => request('name'),
                'status' => request('status'),
                'color' => $color,
                'created_at' => Carbon::now(),
            ]);
        }
    }

    public function edit($id)
    {
        if(request()->ajax()){
            $find = DB::table('class_rooms')->where('id', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'name' => 'required|string|max:50|unique:class_rooms,name,'.$id,
                'status' => 'required|integer',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'name' => 'الصف الدراسي',
                'status' => 'الحالة',
            ]);

            $color = '';
            if((request('color2')) && (request('color'))){
                $color = request('color2');
                
            }elseif( request('color') ){
                $color = request('color');

            }

            DB::table('class_rooms')->where('id', $id)->update([
                'name' => request('name'),
                'status' => request('status'),
                'color' => $color,
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public function datatable()
    {
        $all = DB::table('class_rooms')->get();

        return DataTables::of($all)
            ->addColumn('id', function($res){
                return $res->id;
            })      
            ->addColumn('name', function($res){
                return $res->name;
            })      
            ->addColumn('color', function($res){
                return "<p style='height: 20px;padding-top: 2px;margin: 0 !important;background: ".$res->color."'>".$res->color."</p>";
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
                    <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="'.$res->id.'">
                        <i class="fas fa-marker"></i>
                    </button>
                ';
            })
            ->rawColumns(['id', 'name', 'color', 'status', 'action'])
            ->toJson();
    }
}
