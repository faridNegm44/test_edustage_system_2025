<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class TeacherAccountingTypeController extends Controller
{
    public function index()
    {                               
        $pageNameAr = 'طريقة حساب المدرس';
        $pageNameEn = 'teacher_accounting_type';
        $teachers = DB::table('tbl_teachers')->where('TheStatus', 'مفعل')->select('TheName', 'ID')->get();

        return view('back.teacher_accounting_type.index' , compact('pageNameAr' , 'pageNameEn', 'teachers'));
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'teacher' => 'required|exists:tbl_teachers,ID|unique:teacher_accounting_types,teacher',
                'static_value' => 'nullable|numeric|min:0',
                'percentage_value' => 'nullable|numeric|min:0|max:100',
                'tax' => 'nullable|numeric|min:0',
            ],[
                'required' => ':attribute مطلوب.',
                'numeric' => ':attribute غير صحيح.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'unique' => 'حقل :attribute تم اضافة قيم للمدرس من قبل.',
                'exists' => ':attribute غير موجود في قاعدة البيانات.',
            ],[
                'teacher' => 'المدرس',
                'static_value' => 'القيمة الثابتة',
                'percentage_value' => 'نسبة',
                'tax' => 'ضريبة',
            ]);

            $data = request()->except('_token');
            $data['static_value'] = request('static_value') ?? 0;
            $data['percentage_value'] = request('percentage_value') ?? 0;
            $data['tax'] = request('tax') ?? 0;
            $data['created_at'] = now();

            DB::table('teacher_accounting_types')->insert($data);
        }
    }

    public function edit($id)
    {
        if(request()->ajax()){
            $find = DB::table('teacher_accounting_types')->where('id', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'teacher' => 'required|exists:tbl_teachers,ID|unique:teacher_accounting_types,teacher,'.$id,
                'static_value' => 'nullable|numeric|min:0',
                'percentage_value' => 'nullable|numeric|min:0|max:100',
            ],[
                'required' => ':attribute مطلوب.',
                'numeric' => ':attribute غير صحيح.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'unique' => 'حقل :attribute تم اضافة قيم للمدرس من قبل.',
                'exists' => ':attribute غير موجود في قاعدة البيانات.',
            ],[
                'teacher' => 'المدرس',
                'static_value' => 'القيمة الثابتة',
                'percentage_value' => 'نسبة',
            ]);

            $data = request()->except('_token');
            $data['static_value'] = request('static_value') ?? 0;
            $data['percentage_value'] = request('percentage_value') ?? 0;

            DB::table('teacher_accounting_types')->where('id', $id)->update($data);
        }
    }

    public function datatable()
    {
        $all = DB::table('teacher_accounting_types')
                ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'teacher_accounting_types.teacher')
                ->select('tbl_teachers.TheName', 'tbl_teachers.ID', 'teacher_accounting_types.*')
                ->get();

        return DataTables::of($all)
            ->addColumn('ID', function($res){
                return $res->ID;
            })      
            ->addColumn('TheName', function($res){
                return $res->TheName;
            })      
            ->addColumn('created_at', function($res){
                if($res->created_at){
                    return Carbon::parse($res->created_at)->format('d-m-Y h:i A');
                }
            })      
            ->addColumn('action', function($res){
                return '
                    <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="'.$res->id.'">
                        <i class="fas fa-marker"></i>
                    </button>
                ';
            })
            ->rawColumns(['ID', 'TheName', 'created_at', 'action'])
            ->toJson();
    }
}
