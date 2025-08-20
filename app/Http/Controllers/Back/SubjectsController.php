<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Rooms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class SubjectsController extends Controller
{
    public function index()
    {                              
        $pageNameAr = 'الصفوف و المواد الدراسية';
        $pageNameEn = 'subjects';
        $class_rooms = DB::table('tbl_years_mat')->select('TheYear')->distinct()->orderBy('TheYear', 'asc')->get();
        $subjects = DB::table('tbl_years_mat')->select('TheMat')->distinct()->orderBy('TheMat', 'asc')->get();
        $types_of_education = DB::table('tbl_langs')->where('status', 1)->orderBy('LangName', 'asc')->get();

        return view('back.subjects.index' , compact('pageNameAr' , 'pageNameEn', 'class_rooms', 'subjects', 'types_of_education'));
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'TheYear' => 'required|string',
                'TheMat' => 'nullable|string',
                'LangType' => 'required|integer|exists:tbl_langs,LangID',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
                'exists' => ':attribute غير موجود في قاعدة البيانات.',
            ],[
                'TheYear' => 'الصف الدراسي',
                'TheMat' => 'اسم المادة',
                'LangType' => 'نظام التعليم',
                'TheColor' => 'الحالة',
            ]);

            $color = '';
            if((request('TheColor2')) && (request('TheColor'))){
                $color = request('TheColor2');
                
            }elseif( request('TheColor') ){
                $color = request('TheColor');

            }else{
                $color = '#ffffff';
            }

            $TheYear = request('TheYear');
            $TheMat = request('TheMat');
            $subjectsRelClassRoom = DB::table('tbl_years_mat')->where('TheYear', $TheYear)->where('TheMat', $TheMat)->first();

            if($subjectsRelClassRoom){
                return response()->json(['founded' => 'تمت إضافة هذه المادة من قبل لنفس الصف الدراسي']);

            }else{
                DB::table('tbl_years_mat')->insert([
                    'TheFullName' => request('TheYear').' / '.request('TheMat'),
                    'TheYear' => request('TheYear'),
                    'TheMat' => request('TheMat'),
                    'LangType' => request('LangType'),
                    'academic_year' => GetAcademicYaer(),
                    'TheColor' => $color,
                ]);
            }
        }
    }

    public function edit($id)
    {
        if(request()->ajax()){
            $find = DB::table('tbl_years_mat')->where('ID', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'TheYear' => 'required|string',
                'TheMat' => 'nullable|string',
                'LangType' => 'required|integer|exists:tbl_langs,LangID',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
                'exists' => ':attribute غير موجود في قاعدة البيانات.',
            ],[
                'TheYear' => 'الصف الدراسي',
                'TheMat' => 'اسم المادة',
                'LangType' => 'نظام التعليم',
                'TheColor' => 'الحالة',
            ]);

            $color = '';
            if((request('TheColor2')) && (request('TheColor'))){
                $color = request('TheColor2');
                
            }elseif( request('TheColor') ){
                $color = request('TheColor');

            }else{
                $color = '#ffffff';
            }

            $TheYear = request('TheYear');
            $TheMat = request('TheMat');
            
            DB::table('tbl_years_mat')->where('ID', $id)->update([
                'TheFullName' => request('TheYear').' / '.request('TheMat'),
                'TheYear' => request('TheYear'),
                'TheMat' => request('TheMat'),
                'LangType' => request('LangType'),
                'TheColor' => $color,
            ]);
        }
    }

    public function datatable()
    {
        $all = DB::table('tbl_years_mat')
                    ->leftJoin('tbl_langs', 'tbl_langs.LangID', 'tbl_years_mat.LangType')
                    ->leftJoin('academic_years', 'academic_years.id', 'tbl_years_mat.academic_year')
                    ->select(
                        'tbl_years_mat.*',
                        'tbl_langs.LangName',
                        'academic_years.name as academicYearName'
                    )
                    ->get();
                    
        return DataTables::of($all)
            ->addColumn('TheFullName', function($res){
                return $res->TheFullName;
            })      
            ->addColumn('TheYear', function($res){
                return $res->TheYear;
            })      
            ->addColumn('TheMat', function($res){
                return $res->TheMat;
            })      
            ->addColumn('LangType', function($res){
                return $res->LangName;
            })      
            ->addColumn('TheColor', function($res){
                return "<p style='height: 20px;padding-top: 2px;margin: 0 !important;border: 1px solid;background: ".$res->TheColor."'>".$res->TheColor."</p>";
            }) 
            ->addColumn('action', function($res){
                return '
                    <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="'.$res->ID.'">
                        <i class="fas fa-marker"></i>
                    </button>
                ';
            })
            ->rawColumns(['TheFullName', 'TheYear', 'TheMat', 'LangType', 'TheColor', 'action'])
            ->toJson();
    }
}