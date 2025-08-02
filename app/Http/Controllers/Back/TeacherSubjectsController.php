<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class TeacherSubjectsController extends Controller
{    
    public function index($id)
    {
        $pageNameAr = 'الصفوف والمواد الدراسية الخاصة بالمدرس/المدرسة';
        $pageNameEn = 'teacher_subjects';

        $subjects = DB::table('tbl_years_mat')
                        ->select('ID', 'TheMat', 'TheYear', 'TheFullName')
                        ->distinct()
                        ->orderBy('TheYear', 'asc')
                        ->get();
                        
        $teacherInfo = DB::table('tbl_teachers')->where('tbl_teachers.ID', $id)->first();

        if($teacherInfo){
            return view('back.teacher_subjects.index' , compact('pageNameAr' , 'pageNameEn', 'teacherInfo', 'subjects'));
        }else{
            return redirect('/');
        }
    }

    public function store(Request $request, $teacherId, $matId)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'YearID' => 'required|exists:tbl_years_mat,ID',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'YearID' => 'الصفوف والمواد الدراسية',
            ]);


            $findedOrNot = DB::table('tbl_teachers_years_mat')->where('TeacherID', $teacherId)->where('YearID', $matId)->first();

            if($findedOrNot){
                return response()->json(['founded' => 'هذه المادة مسندة للمدرس من قبل 👨‍🏫 ولا يمكن إسنادها مرة أخرى 📚']);
            }else{
                DB::table('tbl_teachers_years_mat')->insert([
                    'TeacherID' => $teacherId,
                    'YearID' => $matId,
                    'academic_year' => GetAcademicYaer()
                ]);
            }
        }
    }
    

    public function destroy($id)
    {
        if(request()->ajax()){

            $getYearId = DB::table('tbl_students_years_mat')->where('ID', $id)->first();
            $foundedData = DB::table('tbl_groups')->where('YearID', $getYearId->YearID)->first();

            if($foundedData){
                return response()->json(['foundedData' => 'لا يمكن حذف المادة لأنها مستخدمة بالفعل في الوقت الحالي 📚👥']);
            }else{
                DB::table('tbl_students_years_mat')->where('ID', $id)->delete();
            }
        }
        //return view('back.welcome');
    }


    ///////////////////////////////////////////////  datatable  ////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function datatable($id)
    {   
        $all = DB::table('tbl_teachers_years_mat')
                    ->where('tbl_teachers_years_mat.TeacherID', $id)
                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_teachers_years_mat.YearID')
                    ->leftJoin('academic_years', 'academic_years.id', 'tbl_teachers_years_mat.academic_year')
                    ->select(
                        'tbl_teachers_years_mat.*', 
                        'tbl_years_mat.TheMat', 'tbl_years_mat.TheYear', 
                        'academic_years.name as academicYearName'
                    )
                    ->orderBy('tbl_teachers_years_mat.ID', 'desc')
                    ->get();

            return DataTables::of($all)
            ->addColumn('action', function($res){
                return '
                    <button type="button" class="btn btn-sm btn-outline-danger delete" data-effect="effect-scale" data-placement="top" data-toggle="tooltip" title="حذف" res_id="'.$res->ID.'" mat="'.$res->TheMat.'" year="'.$res->TheYear.'">
                        <i class="fa fa-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
