<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Back\StudentsRates;

class StudentsRatesReportsController extends Controller
{
    ///////////////////////////////////////////// Students
    public function student_report_get(){
        $pageNameAr = 'تقرير تقييم طالب';
        $pageNameEn = 'student_report';

        $students = DB::table('tbl_students')
                        ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                        ->select('tbl_students.TheName as studentName', 'tbl_students.ID as studentId', 'tbl_parents.TheName0')
                        ->orderBy('tbl_students.TheName', 'asc')
                        ->get();

                        // return $students;
        return view('back.students_rates.student_report.index' , compact('pageNameAr' , 'pageNameEn', 'students'));
    }

    ///////////////////////////////////////////// Report Students
    public function student_pdf()
    {
        $this->validate(request(), [
            'student_id' =>'required',
        ],[
            'required' => ':attribute مطلوب.',
        ],[
            'student_id' => 'اختيار الطالب',
        ]);



        $studentDetails = DB::table('tbl_eval')
                                ->where('Eval_StudentID', request('student_id'))
                                ->leftJoin('tbl_groups', 'tbl_groups.ID', 'tbl_eval.Eval_GroupID')
                                ->leftJoin('tbl_teachers', 'tbl_teachers.ID', "tbl_eval.Eval_TeacherID")
                                ->leftJoin('tbl_students', 'tbl_students.ID', 'tbl_eval.Eval_StudentID')
                                ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                                ->where('tbl_groups.TheStatus', 'مفتوحة')
                                ->select(
                                    "tbl_eval.*",
                                    "tbl_groups.GroupName as groupName",
                                    "tbl_teachers.TheName as teacherName",
                                    "tbl_students.TheName as studentName",
                                    "tbl_parents.TheName0 as parentName",
                                )
                                ->orderBy('tbl_eval.Eval_Year', 'asc')
                                ->orderBy('tbl_eval.Eval_Month', 'asc')
                                ->get();

        // if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2){

        // }elseif(auth()->user()->user_status == 3){

        // }

        // return $studentDetails;

        if(count($studentDetails) == 0){
            return redirect()->back()->with('notFoundRates', 'لاتوجد تقيمات لهذا الطالب ف الوقت الحالي');
        }else{
            $nameAr = 'تقرير تقييم لطالب'.' - '.$studentDetails[0]->studentName.' '.$studentDetails[0]->parentName;
            return view('back.students_rates.student_report.pdf', compact('nameAr', 'studentDetails'));
        }
    }







    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





    ///////////////////////////////////////////// groups
    public function groups_report_get(){
        $pageNameAr = 'تقرير تقييم مجموعة';
        $pageNameEn = 'groups_report';

        $groups = DB::table('tbl_groups')
                    ->where('tbl_groups.TheStatus', 'مفتوحة')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', "tbl_groups.TeacherID")
                    ->select(
                        "tbl_groups.*",
                        "tbl_teachers.TheName as teacherName",
                    )
                    ->orderBy('GroupName', 'asc')
                    ->get();
        return view('back.students_rates.groups_report.index' , compact('pageNameAr' , 'pageNameEn', 'groups'));
    }

    ///////////////////////////////////////////// Report Students
    public function groups_pdf()
    {
        $this->validate(request(), [
            'group_id' =>'required',
        ],[
            'required' => ':attribute مطلوب.',
        ],[
            'group_id' => 'اختيار الطالب',
        ]);

        $groupsDetails = DB::table('tbl_eval')
                                ->where('Eval_GroupID', request('group_id'))
                                ->leftJoin('tbl_groups', 'tbl_groups.ID', 'tbl_eval.Eval_GroupID')
                                ->leftJoin('tbl_teachers', 'tbl_teachers.ID', "tbl_eval.Eval_TeacherID")
                                ->leftJoin('tbl_students', 'tbl_students.ID', 'tbl_eval.Eval_StudentID')
                                ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                                ->where('tbl_groups.TheStatus', 'مفتوحة')
                                ->select(
                                    "tbl_eval.*",
                                    "tbl_groups.GroupName as groupName",
                                    "tbl_teachers.TheName as teacherName",
                                    "tbl_students.TheName as studentName",
                                    "tbl_parents.TheName0 as parentName",
                                )
                                ->orderBy('tbl_eval.Eval_Year', 'asc')
                                ->orderBy('tbl_eval.Eval_Month', 'asc')
                                ->groupBy('tbl_eval.Eval_Month')
                                ->get();

        $groupsDetailsWithOutGroupBy = DB::table('tbl_eval')
                                ->where('Eval_GroupID', request('group_id'))
                                ->leftJoin('tbl_groups', 'tbl_groups.ID', 'tbl_eval.Eval_GroupID')
                                ->leftJoin('tbl_teachers', 'tbl_teachers.ID', "tbl_eval.Eval_TeacherID")
                                ->leftJoin('tbl_students', 'tbl_students.ID', 'tbl_eval.Eval_StudentID')
                                ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                                ->where('tbl_groups.TheStatus', 'مفتوحة')
                                ->select(
                                    "tbl_eval.*",
                                    "tbl_groups.GroupName as groupName",
                                    "tbl_teachers.TheName as teacherName",
                                    "tbl_students.TheName as studentName",
                                    "tbl_parents.TheName0 as parentName",
                                )
                                ->orderBy('tbl_eval.Eval_Year', 'asc')
                                ->orderBy('tbl_eval.Eval_Month', 'asc')
                                ->orderBy('tbl_students.TheName', 'asc')
                                ->get();


        // return $groupsDetails;

        if(count($groupsDetails) == 0){
            return redirect()->back()->with('notFoundRates', 'لاتوجد تقيمات لهذة المجموعة  ف الوقت الحالي');
        }else{
            $nameAr = 'تقرير تقييم لمجموعة'.' - '.$groupsDetails[0]->groupName;
            return view('back.students_rates.groups_report.pdf', compact('nameAr', 'groupsDetails', 'groupsDetailsWithOutGroupBy'));
        }
    }















    ///////////////////////////////////////////// groups_rated_report ///////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////


    ///////////////////////////////////////////// groups
    public function groups_rated_report_get(){
        $pageNameAr = 'تقرير جروبات تم تقييمها';
        return view('back.students_rates.groups_rated_report.index' , compact('pageNameAr'));
    }


    ///////////////////////////////////////////// Report Teacher
    public function groups_rated_pdf(Request $request)
    {
        $this->validate(request(), [
            'start' =>'required',
            'end' =>'required',
        ],[
            'required' => ':attribute مطلوب.',
        ],[
            'start' => 'تاريخ البداية',
            'end' => 'تاريخ النهاية',
        ]);

        $start = request('start');
        $end = request('end');

        $groupsRated = DB::table('tbl_eval')
                        ->whereBetween('Eval_date', [$start, $end])
                        ->leftJoin('tbl_groups', 'tbl_groups.ID', 'tbl_eval.Eval_GroupID')
                        ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_eval.Eval_TeacherID')
                        ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_eval.Eval_Years_Mat')
                        ->where('tbl_groups.TheStatus', 'مفتوحة')
                        ->select(
                            'tbl_eval.*',
                            'tbl_groups.ID as groupId', 'tbl_groups.GroupName as groupName',
                            'tbl_teachers.TheName as teacherName',
                            'tbl_years_mat.TheFullName as matName',
                        )
                        ->groupBy('tbl_eval.Eval_GroupID')
                        ->orderBy('tbl_teachers.TheName', 'asc')
                        ->get();

        // return $groupsRated;

        $nameAr = 'تقرير لجروبات تم تقييمها';
        return view('back.students_rates.groups_rated_report.pdf', compact('nameAr', 'start', 'end', 'groupsRated'));
    }








    ///////////////////////////////////////////// groups_not_rated_report ///////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////


    ///////////////////////////////////////////// groups
    public function groups_not_rated_report_get(){
        $pageNameAr = 'تقرير لجروبات لم يتم تقييمها';
        return view('back.students_rates.groups_not_rated_report.index' , compact('pageNameAr'));
    }


    ///////////////////////////////////////////// Report Teacher
    public function groups_not_rated_pdf(Request $request)
    {
        $this->validate(request(), [
            'month' =>'required',
        ],[
            'required' => ':attribute مطلوب.',
        ],[
            'month' => 'إختيار الشهر',
        ]);

        $month = request('month');
        $start = date('Y-'.$month.'-01');
        $end = date('Y-'.$month.'-31');

        $allGroups = DB::table('tbl_groups')->where('TheStatus', 'مفتوحة')->count();

        $groupsRated = DB::table('tbl_eval')
                        ->where('Eval_Month', $month)
                        ->groupBy('Eval_GroupID')
                        ->pluck('Eval_GroupID');

        $unratedGroups = DB::table('tbl_groups')
                            ->where('tbl_groups.TheStatus', 'مفتوحة')
                            ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_groups.TeacherID')
                            ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                            ->whereNotIn('tbl_groups.ID', $groupsRated)
                            ->select(
                                'tbl_groups.ID as groupId', 'tbl_groups.GroupName as groupName',
                                'tbl_teachers.TheName as teacherName',
                                'tbl_years_mat.TheFullName as matName',
                            )
                            ->orderBy('tbl_teachers.TheName', 'asc')
                            ->get();

        // return $unratedGroups;

        $nameAr = 'تقرير لجروبات لم يتم تقييمها لشهر - '.$month;
        return view('back.students_rates.groups_not_rated_report.pdf', compact('nameAr', 'allGroups', 'month', 'start', 'end', 'groupsRated', 'unratedGroups'));
    }

}
