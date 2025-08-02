<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Rooms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class TypesOfEducationController extends Controller
{
    public function index()
    {                               
        $pageNameAr = 'أنواع التعليم';
        $pageNameEn = 'types_of_education';
        
        return view('back.types_of_education.index' , compact('pageNameAr' , 'pageNameEn'));
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'LangName' => 'required|string|max:50|unique:tbl_langs,LangName',
                'status' => 'required|integer',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'LangName' => 'نوع التعليم',
                'status' => 'الحالة',
            ]);

            $data = request()->except('_token');
            $data['created_at'] = Carbon::now();
            $data['academic_year'] = GetAcademicYaer();

            DB::table('tbl_langs')->insert($data);
        }
    }

    public function edit($id)
    {
        if(request()->ajax()){
            $find = DB::table('tbl_langs')->where('LangID', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'LangName' => 'required|string|max:50|unique:tbl_langs,LangName,'.$id.',LangID',
                'status' => 'required|integer',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'LangName' => 'نوع التعليم',
                'status' => 'الحالة',
            ]);

            $data = request()->except('_token');
            $data['updated_at'] = Carbon::now();

            DB::table('tbl_langs')->where('LangID', $id)->update($data);
        }
    }

    public function datatable()
    {
        $all = DB::table('tbl_langs')
                ->leftJoin('academic_years', 'academic_years.id', 'tbl_langs.academic_year')
                ->select('academic_years.name as academicYearName', 'tbl_langs.*')
                ->get();

        return DataTables::of($all)
            ->addColumn('LangID', function($res){
                return $res->LangID;
            })      
            ->addColumn('LangName', function($res){
                return $res->LangName;
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
                    <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="'.$res->LangID.'">
                        <i class="fas fa-marker"></i>
                    </button>
                ';
            })
            ->rawColumns(['LangID', 'LangName', 'status', 'action'])
            ->toJson();
    }
}
