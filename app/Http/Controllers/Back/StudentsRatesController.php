<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\StudentsRates;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class StudentsRatesController extends Controller
{

    public function teacherId()
    {
        return $teacherId = DB::table('tbl_teachers')->where('tbl_teachers.UserID', auth()->user()->id)->first();
    }


   public function index()
    {            
        //dd($this->teacherId());
        // $all = DB::table('tbl_eval')
        //         ->leftJoin('tbl_groups', 'tbl_groups.ID', 'tbl_eval.Eval_GroupID')
        //         ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
        //         ->select('tbl_eval.*', 'tbl_groups.GroupName', 'tbl_years_mat.TheFullName')
        //         ->where('Eval_TeacherID', $this->teacherId()->ID)
        //         ->groupBy(['Eval_Date', 'Eval_TeacherID', 'Eval_Month'])
        //         ->orderBy('Eval_Date', 'desc')
        //         ->get();
        //         return $all;
                
        $pageNameAr = 'تقييم الطلاب';
        $pageNameEn = 'students_rates';
        $teachers = DB::table('tbl_teachers')->orderBy('TheName', 'asc')->get();

        $groups = DB::table('tbl_teachers')
                    ->where('tbl_teachers.UserID', auth()->user()->id)
                    ->leftJoin('tbl_groups', 'tbl_groups.TeacherID', 'tbl_teachers.ID')
                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                    ->select('tbl_groups.*', 'tbl_years_mat.TheFullName as matFullName')
                    ->orderBy('tbl_groups.OpenDate', 'asc')
                    ->get();
        
        $beforeMonth = now()->subMonth()->month;

        return view('back.students_rates.index' , compact('pageNameAr' , 'pageNameEn', 'teachers', 'groups', 'beforeMonth'));
    }

    



    public function getStudentsToEstimate($groupId)
    {     
        $find = DB::table('tbl_groups_students')
                    ->where('GroupID', $groupId)
                    ->leftJoin('tbl_groups', 'tbl_groups.ID', 'tbl_groups_students.GroupID')
                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                    ->leftJoin('tbl_students', 'tbl_students.ID', 'tbl_groups_students.StudentID')
                    ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                    ->select('tbl_groups_students.*', 'tbl_students.ID as studentId', 'tbl_students.TheName as studentName', 'tbl_parents.TheName0 as parentName', 'tbl_years_mat.ID as matId')
                    ->orderBy('tbl_students.TheName', 'asc')         
                    ->get();

        return response()->json($find);
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $Eval_GroupID = $request->input('Eval_GroupID');
            $Eval_Month = $request->input('Eval_Month');

            $existingRecord = StudentsRates::where('Eval_GroupID', $Eval_GroupID)
                                            ->where('Eval_Month', $Eval_Month)
                                            ->where('Eval_TeacherID', $this->teacherId()->ID)
                                            ->first();

            if($existingRecord){
                return response()->json(['foundeGroupAndMonth' => 'error']);
            }else{ 
                $this->validate($request , [
                    'Eval_GroupID' => 'required|integer',
                    'Eval_Month' => 'required|integer',
                    'Eval_Att.*' => 'required|numeric|max:10',
                    'Eval_Part.*' => 'required|numeric|max:10',
                    'Eval_Eval.*' => 'required|numeric|max:40',
                    'Eval_HW.*' => 'required|numeric|max:40',
                    'Eval_Degree.*' => 'required|numeric|max:100',
                ],[
                    'required' => ':attribute مطلوب.',
                    'numeric' => ':attribute غير صحيح.',
                ],[
                    'Eval_GroupID' => 'المجموعات الدراسية',
                    'Eval_Month' => 'الشهر',
                ]);
    
    
                for ($i = 0; $i < count($request->Eval_StudentID); $i++) {
                    $data[] = [
                        'Eval_Date' => Carbon::now()->toDateString(),
                        'Eval_GroupID' => request('Eval_GroupID'),
                        'Eval_TeacherID' => $this->teacherId()->ID,
                        'Eval_Years_Mat' => request('Eval_Years_Mat'),
                        'Eval_StudentID' => request('Eval_StudentID')[$i],
                        'Eval_TeacherComment' => request('Eval_TeacherComment')[$i],
                        'Eval_TeacherSugg' => request('Eval_TeacherSugg')[$i],
                        'Eval_Count' => 0,
                        'Eval_Att' => request('Eval_Att')[$i],
                        'Eval_Part' => request('Eval_Part')[$i],
                        'Eval_Eval' => request('Eval_Eval')[$i],
                        'Eval_HW' => request('Eval_HW')[$i],
                        'Eval_Degree' => request('Eval_Degree')[$i],
                        'Eval_Month' => request('Eval_Month'),
                        'Eval_Year' => now()->year,
                        'Eval_Total' => 0,
                    ];
                }
                StudentsRates::insert($data);
            }  // end if
        }
    }

    public function show($group, $month)
    {
        if(request()->ajax()){
            if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){
                $find = StudentsRates::where('Eval_GroupID', $group)
                                    ->where('Eval_Month', $month)
                                    ->leftJoin('tbl_groups', 'tbl_groups.ID', 'tbl_eval.Eval_GroupID')
                                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                                    ->leftJoin('tbl_students', 'tbl_students.ID', 'tbl_eval.Eval_StudentID')
                                    ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                                    ->select('tbl_eval.*', 'tbl_groups.GroupName', 'tbl_years_mat.TheFullName as matFullName', 'tbl_students.TheName as studentName', 'tbl_parents.TheName0 as parentName',)       
                                    ->orderBy('tbl_students.TheName', 'asc')         
                                    ->get();

            }elseif(auth()->user()->user_status == 4){
                $find = StudentsRates::where('Eval_GroupID', $group)
                                    ->where('Eval_Month', $month)
                                    ->where('Eval_TeacherID', $this->teacherId()->ID)
                                    ->leftJoin('tbl_groups', 'tbl_groups.ID', 'tbl_eval.Eval_GroupID')
                                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                                    ->leftJoin('tbl_students', 'tbl_students.ID', 'tbl_eval.Eval_StudentID')
                                    ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                                    ->select('tbl_eval.*', 'tbl_groups.GroupName', 'tbl_years_mat.TheFullName as matFullName', 'tbl_students.TheName as studentName', 'tbl_parents.TheName0 as parentName',)       
                                    ->orderBy('tbl_students.TheName', 'asc')         
                                    ->get();    
            }
            return response()->json($find);
        }
        return view('back.welcome');
    }


    public function edit($group, $month)
    {
        if(request()->ajax()){
            $find = StudentsRates::where('Eval_GroupID', $group)
                                ->where('Eval_Month', $month)
                                ->where('Eval_TeacherID', $this->teacherId()->ID)
                                ->leftJoin('tbl_groups', 'tbl_groups.ID', 'tbl_eval.Eval_GroupID')
                                ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                                ->leftJoin('tbl_students', 'tbl_students.ID', 'tbl_eval.Eval_StudentID')
                                ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                                ->select('tbl_eval.*', 'tbl_groups.GroupName', 'tbl_years_mat.TheFullName as matFullName', 'tbl_students.ID as studentId', 'tbl_students.TheName as studentName', 'tbl_parents.TheName0 as parentName',)       
                                ->orderBy('tbl_students.TheName', 'asc')         
                                ->get();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request)
    {
        $this->validate($request , [
            'Eval_Att.*' => 'required|numeric|max:10',
            'Eval_Part.*' => 'required|numeric|max:10',
            'Eval_Eval.*' => 'required|numeric|max:40',
            'Eval_HW.*' => 'required|numeric|max:40',
            'Eval_Degree.*' => 'required|numeric|max:100',
        ]);

        foreach (request('Eval_StudentIDEdit') as $key => $value) {
            StudentsRates::where('Eval_ID', $value)->update([
                'Eval_TeacherComment' => request('Eval_TeacherComment')[$key],
                'Eval_TeacherSugg' => request('Eval_TeacherSugg')[$key],
                'Eval_Count' => 0,
                'Eval_Att' => request('Eval_Att')[$key],
                'Eval_Part' => request('Eval_Part')[$key],
                'Eval_Eval' => request('Eval_Eval')[$key],
                'Eval_HW' => request('Eval_HW')[$key],
                'Eval_Degree' => request('Eval_Degree')[$key],
            ]);
        }
    }

     
    public function destroy($group, $month)
    {
        if(request()->ajax()){
            StudentsRates::where('Eval_GroupID', $group)->where('Eval_Month', $month)->where('Eval_TeacherID', $this->teacherId()->ID)->delete();
        }
    }



    public function datatable()
    {
        if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){
            $all = DB::table('tbl_eval')
                    ->leftJoin('tbl_groups', 'tbl_groups.ID', 'tbl_eval.Eval_GroupID')
                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_eval.Eval_TeacherID')
                    ->select('tbl_eval.*', 'tbl_groups.GroupName', 'tbl_years_mat.TheFullName', 'tbl_teachers.TheName as teacherName')
                    ->groupBy(['Eval_Date', 'Eval_GroupID', 'Eval_Month'])
                    ->orderBy('Eval_Date', 'desc')
                    ->get();

        }elseif(auth()->user()->user_status == 4){
            $all = DB::table('tbl_eval')
                    ->leftJoin('tbl_groups', 'tbl_groups.ID', 'tbl_eval.Eval_GroupID')
                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_eval.Eval_TeacherID')
                    ->select('tbl_eval.*', 'tbl_groups.GroupName', 'tbl_years_mat.TheFullName', 'tbl_teachers.TheName as teacherName')
                    ->where('Eval_TeacherID', $this->teacherId()->ID)
                    ->groupBy(['Eval_Date', 'Eval_GroupID', 'Eval_Month'])
                    ->orderBy('Eval_Date', 'desc')
                    ->get();
        }

        return DataTables::of($all)
            ->addColumn('GroupName', function($res){
                return $res->GroupName;
            })      
            ->addColumn('teacherName', function($res){
                return $res->teacherName;
            })      
            ->addColumn('TheFullName', function($res){
                return $res->TheFullName;
            })      
            ->addColumn('Eval_Month', function($res){
                return $res->Eval_Month;
            })      
            ->addColumn('Eval_Year', function($res){
                return $res->Eval_Year;
            })      
            ->addColumn('Eval_Date', function($res){
                return $res->Eval_Date;
            })      
            
            ->addColumn('action', function($res){

                $currentMonth = Carbon::now()->month;
                $lastMonth = Carbon::now()->subMonth()->month;
                
                if ($res->Eval_Month == $currentMonth || $res->Eval_Month == $lastMonth) {
                    return '
                            <button type="button" class="btn btn-sm btn-outline-danger delete DBtn" data-placement="top" data-toggle="tooltip" title="حذف" Eval_GroupID	="'.$res->Eval_GroupID.'" GroupName	="'.$res->GroupName.'" Eval_Month="'.$res->Eval_Month.'">
                                <i class="fa fa-trash"></i>
                            </button>
                            
                            <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" Eval_GroupID	="'.$res->Eval_GroupID.'" Eval_Month="'.$res->Eval_Month.'">
                                <i class="fas fa-marker"></i>
                            </button>

                            <button type="button" class="btn btn-sm btn-outline-success show" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenterShow" data-placement="top" data-toggle="tooltip" title="عرض" Eval_GroupID	="'.$res->Eval_GroupID.'" Eval_Month="'.$res->Eval_Month.'">
                                <i class="fas fa-eye"></i>
                            </button>

                        ';
                }else{
                    return '
                        <button type="button" class="btn btn-sm btn-outline-success show" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenterShow" data-placement="top" data-toggle="tooltip" title="عرض" Eval_GroupID	="'.$res->Eval_GroupID.'" Eval_Month="'.$res->Eval_Month.'">
                            <i class="fas fa-eye"></i>
                        </button>

                    ';

                }


            })
            ->rawColumns(['GroupName', 'teacherName', 'TheFullName', 'Eval_Month', 'Eval_Year', 'Eval_Date', 'action'])
            ->toJson();
    }
}