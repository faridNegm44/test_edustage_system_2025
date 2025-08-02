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

class StudentsWishlistController extends Controller
{
    public function index()
    {
        $pageNameAr = 'لائحة رغبات الطلاب';
        $pageNameEn = 'students_wishlist';
        $academic_years = DB::table('academic_years')->orderBy('id', 'asc')->get();

        return view('back.students_wishlist.index' , compact('pageNameAr' , 'pageNameEn', 'academic_years'));
    }
    
    public function index_student_wishlist($id)
    {
        $pageNameAr = 'رغبات الطالب/الطالبة';
        $pageNameEn = 'students_wishlist';
        $academic_years = DB::table('academic_years')->orderBy('id', 'asc')->get();
        $subjects = DB::table('tbl_years_mat')
                        ->select('ID', 'TheMat', 'TheYear', 'TheFullName')
                        ->distinct()
                        ->orderBy('TheYear', 'asc')
                        ->get();
                        
        $studentInfo = DB::table('tbl_students')
                            ->where('tbl_students.ID', $id)
                            ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                            ->select(
                                'tbl_students.*', 
                                'tbl_parents.TheName0 as parentName', 
                            )
                            ->first();

        if($studentInfo){
            return view('back.students_wishlist.index_student_wishlist' , compact('pageNameAr' , 'pageNameEn', 'academic_years', 'studentInfo', 'subjects'));
        }else{
            return redirect('/');
        }
    }

    public function store(Request $request, $studentId, $matId)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'ThePackage' => 'required|string',
                'TheTime' => 'required|string',
                'YearID' => 'required|exists:tbl_years_mat,ID',
                'TheNotes' => 'nullable|string',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'ThePackage' => 'الباقة',
                'TheTime' => 'الفترة',
                'YearID' => 'الصفوف والمواد الدراسية',
                'TheNotes' => 'ملاحظات',
            ]);


            $findedOrNot = DB::table('tbl_students_years_mat')->where('StudentID', $studentId)->where('YearID', $matId)->first();

            if($findedOrNot){
                return response()->json(['founded' => '⚠️ هذه المادة مسجّلة بالفعل ضمن رغباتك من قبل 📚']);
            }else{
                DB::table('tbl_students_years_mat')->insert([
                    'StudentID' => $studentId,
                    'YearID' => $matId,
                    'TheTime' => request('TheTime'),
                    'ThePackage' => request('ThePackage'),
                    'TheDate' => now(),
                    'TheNotes' => request('TheNotes') ?? '',
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
                return response()->json(['foundedData' => 'لا يمكن حذف الرغبة لأنها مضافة إلى مجموعات بالفعل 📚👥']);
            }else{
                DB::table('tbl_students_years_mat')->where('ID', $id)->delete();
            }
        }
        //return view('back.welcome');
    }


    ///////////////////////////////////////////////  datatable لائحة رغبات الطلاب  ////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function datatable(Request $request)
    {   
        $academic_year = $request->academic_year;
        $from = $request->from ?? null;
        $to = $request->to ?? null;

        $query = DB::table('tbl_students_years_mat')
                    ->leftJoin('tbl_students', 'tbl_students.ID', 'tbl_students_years_mat.StudentID')
                    ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_students_years_mat.YearID')
                    ->leftJoin('tbl_langs', 'tbl_langs.LangID', 'tbl_years_mat.LangType')
                    ->leftJoin('academic_years', 'academic_years.id', 'tbl_students_years_mat.academic_year')
                    ->select(
                        'tbl_students_years_mat.*', 
                        'tbl_students.TheName as studentName', 'tbl_students.ThePhone', 'tbl_students.TheTestType',
                        'tbl_parents.TheName0 as parentName', 'tbl_parents.ThePhone2', 
                        'tbl_years_mat.TheMat', 'tbl_years_mat.TheYear', 
                        'tbl_langs.LangName', 
                        'academic_years.name as academicYearName'
                    )
                    ->orderBy('tbl_students_years_mat.ID', 'desc');

            if ($from && $to) {
                $query->whereBetween('tbl_students_years_mat.TheDate', [$from, $to]);
            } elseif ($from) {
                $query->where('tbl_students_years_mat.TheDate', '>=', $from);
            } elseif ($to) {
                $query->where('tbl_students_years_mat.TheDate', '<=', $to);
            }
            
            if($academic_year){
                $query->where('tbl_students_years_mat.academic_year', $academic_year);
            }
            //else{
            //    $query->where('tbl_students_years_mat.academic_year', GetAcademicYaer());
            //}

            $all = $query->get();

            return DataTables::of($all)
            ->addColumn('ThePhone2', function($res){     
                if(!$res->ThePhone2){
                    return '';
                }else{
                    return '
                        <a class="ThePhone2 text-right text-success d-block" href="https://wa.me/'.$res->ThePhone2.'" target="_blank" style="font-size: 12px;">
                            <i class="fab fa-whatsapp" style="margin: 3px;position: relative;top: 2px;"></i>
                            '.$res->ThePhone2.'
                        </a>
                    ';

                }        
            }) 
            ->rawColumns(['ThePhone2'])
            ->toJson();
    }


    ///////////////////////////////////////////////  datatable_student_wishlist  رغبات الطالب ////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function datatable_student_wishlist(Request $request, $id)
    {   
        $academic_year = $request->academic_year;
        $from = $request->from ?? null;
        $to = $request->to ?? null;

        $query = DB::table('tbl_students_years_mat')
                    ->where('tbl_students_years_mat.StudentID', $id)
                    ->leftJoin('tbl_students', 'tbl_students.ID', 'tbl_students_years_mat.StudentID')
                    ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_students_years_mat.YearID')
                    ->leftJoin('tbl_langs', 'tbl_langs.LangID', 'tbl_years_mat.LangType')
                    ->leftJoin('academic_years', 'academic_years.id', 'tbl_students_years_mat.academic_year')
                    ->select(
                        'tbl_students_years_mat.*', 
                        'tbl_students.TheName as studentName', 'tbl_students.ThePhone', 'tbl_students.TheTestType',
                        'tbl_parents.TheName0 as parentName', 'tbl_parents.ThePhone2', 
                        'tbl_years_mat.TheMat', 'tbl_years_mat.TheYear', 
                        'tbl_langs.LangName', 
                        'academic_years.name as academicYearName'
                    )
                    ->orderBy('tbl_students_years_mat.ID', 'desc');

            if ($from && $to) {
                $query->whereBetween('tbl_students_years_mat.TheDate', [$from, $to]);
            } elseif ($from) {
                $query->where('tbl_students_years_mat.TheDate', '>=', $from);
            } elseif ($to) {
                $query->where('tbl_students_years_mat.TheDate', '<=', $to);
            }
            
            if($academic_year){
                $query->where('tbl_students_years_mat.academic_year', $academic_year);
            }

            $all = $query->get();

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
