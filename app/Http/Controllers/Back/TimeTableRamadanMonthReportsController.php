<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\Back\TimeTable;
use App\Models\Back\TimeTableHistory;
use App\Models\Back\Times;
use App\Models\Back\Teach;

class TimeTableRamadanMonthReportsController extends Controller
{
    ///////////////////////////////////////////// Teacher
    public function teacher_report_get(){
        $pageNameAr = 'تقرير حصص المدرسين لشهر رمضان';
        $pageNameEn = 'teacher_report';

        $teachers = DB::table('tbl_teachers')
                        ->leftJoin('tbl_groups', 'tbl_groups.TeacherID', 'tbl_teachers.ID')
                        ->select('tbl_teachers.TheName as teacherName', 'tbl_teachers.ID as teacherId', 'tbl_groups.GroupName')
                        ->orderBy('TheName', 'Asc')
                        ->get();
        return view('back.time_table_ramadan_month.teacher_report.index' , compact('pageNameAr' , 'pageNameEn', 'teachers'));
    }

    ///////////////////////////////////////////// Report Teacher
    public function teacher_pdf()
    {
        $this->validate(request(), [
            'teacher_id' =>'required',
        ],[
            'required' => ':attribute مطلوب.',
        ],[
            'teacher_id' => 'اختيار المدرس',
        ]);

        $teacherDetails = DB::table('tbl_groups')
                            ->where('TeacherID', request('teacher_id'))
                            ->leftJoin('time_tables_ramadan_month', 'time_tables_ramadan_month.group_id', 'tbl_groups.ID')
                            ->leftJoin('tbl_teachers', 'tbl_teachers.ID', "tbl_groups.TeacherID")
                            ->leftJoin('tbl_rooms', 'tbl_rooms.RoomID', "time_tables_ramadan_month.room_id")
                            ->select(
                                "time_tables_ramadan_month.*",
                                "tbl_groups.GroupName as groupName",
                                "tbl_teachers.TheName as teacherName", "tbl_teachers.ID as teacherId", "tbl_teachers.ID as teacherId", "tbl_teachers.TheEmail as teacherEmail", "tbl_teachers.ThePhone1 as teacherPhone1", "tbl_teachers.ThePhone2 as teacherPhone2",
                                "tbl_rooms.RoomName as roomName",
                            )
                            ->groupBy('time_tables_ramadan_month.group_to_colspan')
                            ->get();


                            // return $teacherDetails;

        if(count($teacherDetails) == 0){
            return redirect()->back();
        }else{
            $nameAr = 'تقرير حصص المدرسين لشهر رمضان'.' - '.$teacherDetails[0]->teacherName;
            return view('back.time_table_ramadan_month.teacher_report.pdf', compact('nameAr', 'teacherDetails'));
        }
    }







    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





    ///////////////////////////////////////////// groups
    public function groups_report_get(){
        $pageNameAr = 'تقرير حصص لجروبات لشهر رمضان';
        $pageNameEn = 'groups_report';

        $tblYearsMat = DB::table('tbl_years_mat')
                            ->distinct('TheYear')
                            ->select('TheYear')
                            ->orderBy('ID', 'Asc')
                            ->get();
        // dd($tblYearsMat);

        $groups = DB::table('tbl_teachers')
                        ->leftJoin('tbl_groups', 'tbl_groups.TeacherID', 'tbl_teachers.ID')
                        ->select('tbl_teachers.TheName as teacherName', 'tbl_teachers.ID as teacherId', 'tbl_groups.GroupName')
                        ->orderBy('TheName', 'Asc')
                        ->get();

        return view('back.time_table_ramadan_month.groups_report.index' , compact('pageNameAr' , 'pageNameEn', 'groups', 'tblYearsMat'));
    }

    ///////////////////////////////////////////// get_groups
    public function get_groups($id)
    {
        $allMats = DB::table('tbl_years_mat')
                    ->leftJoin('tbl_groups', 'tbl_groups.YearID', 'tbl_years_mat.ID')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_groups.YearID')
                    ->where('tbl_years_mat.TheYear', $id)
                    ->select(
                        'tbl_years_mat.TheMat as theMat',
                        'tbl_teachers.TheName as teacherName',
                        'tbl_groups.GroupName as groupName', 'tbl_groups.ID as groupId',
                        )
                    ->get();

        return response()->json(['allMats' => $allMats]);
    }

    ///////////////////////////////////////////// Report Teacher
    public function groups_pdf(Request $request)
    {
        $this->validate(request(), [
            'years_mat' =>'required',
            'groups' =>'required',
        ],[
            'required' => ':attribute مطلوب.',
        ],[
            'years_mat' => 'اختيار المدرس',
            'groups' => 'اختيار الجروب',
        ]);

        $countReqGroup = count(request('groups'));

        $groupsDetails = DB::table('time_tables_ramadan_month')
                            ->whereIn('group_id', request('groups'))
                            ->leftJoin('tbl_groups', 'tbl_groups.ID', 'time_tables_ramadan_month.group_id')
                            ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                            ->leftJoin('tbl_teachers', 'tbl_teachers.ID', "tbl_groups.TeacherID")
                            ->leftJoin('tbl_rooms', 'tbl_rooms.RoomID', "time_tables_ramadan_month.room_id")
                            ->select(
                                "time_tables_ramadan_month.*",
                                "tbl_groups.GroupName as groupName",
                                "tbl_years_mat.TheMat as theMat",
                                "tbl_teachers.TheName as teacherName",
                                "tbl_rooms.RoomName as roomName",
                            )
                            ->orderBy('tbl_groups.GroupName', 'asc')
                            ->groupBy('time_tables_ramadan_month.group_to_colspan')
                            ->get();

        if(count($groupsDetails) == 0){
            return redirect()->back();
        }else{
            $nameAr = 'تقرير حصص لجروبات لشهر رمضان';
            return view('back.time_table_ramadan_month.groups_report.pdf', compact('nameAr', 'groupsDetails', 'countReqGroup'));
        }
    }







    ///////////////////////////////////////////// groups_not_rated_report ///////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////


    ///////////////////////////////////////////// groups
    public function groups_not_rated_report_get(){
        $pageNameAr = 'تقرير لجروبات لم يتم تقييمها';
        $pageNameEn = 'groups_not_rated_report';

        $tblYearsMat = DB::table('tbl_years_mat')
                            ->distinct('TheYear')
                            ->select('TheYear')
                            ->orderBy('ID', 'Asc')
                            ->get();
        // dd($tblYearsMat);

        $groups = DB::table('tbl_teachers')
                        ->leftJoin('tbl_groups', 'tbl_groups.TeacherID', 'tbl_teachers.ID')
                        ->select('tbl_teachers.TheName as teacherName', 'tbl_teachers.ID as teacherId', 'tbl_groups.GroupName')
                        ->orderBy('TheName', 'Asc')
                        ->get();

        return view('back.time_table_ramadan_month.groups_not_rated_report.index' , compact('pageNameAr' , 'pageNameEn', 'groups', 'tblYearsMat'));
    }

    ///////////////////////////////////////////// Report Teacher
    public function groups_not_rated_pdf(Request $request)
    {
        $this->validate(request(), [
            'years_mat' =>'required',
            'groups' =>'required',
        ],[
            'required' => ':attribute مطلوب.',
        ],[
            'years_mat' => 'اختيار المدرس',
            'groups' => 'اختيار الجروب',
        ]);

        $countReqGroup = count(request('groups'));

        $groupsDetails = DB::table('time_tables_ramadan_month')
                            ->whereIn('group_id', request('groups'))
                            ->leftJoin('tbl_groups', 'tbl_groups.ID', 'time_tables_ramadan_month.group_id')
                            ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                            ->leftJoin('tbl_teachers', 'tbl_teachers.ID', "tbl_groups.TeacherID")
                            ->leftJoin('tbl_rooms', 'tbl_rooms.RoomID', "time_tables_ramadan_month.room_id")
                            ->select(
                                "time_tables_ramadan_month.*",
                                "tbl_groups.GroupName as groupName",
                                "tbl_years_mat.TheMat as theMat",
                                "tbl_teachers.TheName as teacherName",
                                "tbl_rooms.RoomName as roomName",
                            )
                            ->orderBy('tbl_groups.GroupName', 'asc')
                            ->groupBy('time_tables_ramadan_month.group_to_colspan')
                            ->get();

        if(count($groupsDetails) == 0){
            return redirect()->back();
        }else{
            $nameAr = 'تقرير حصص الجروبات';
            return view('back.time_table_ramadan_month.groups_not_rated_report.pdf', compact('nameAr', 'groupsDetails', 'countReqGroup'));
        }
    }

}
