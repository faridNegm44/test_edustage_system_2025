<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportsTeacherCommitmentController extends Controller
{
    public function index()
    {                              
        $pageNameAr = 'كشف إلتزام المدرسين';
        $pageNameEn = 'teachers/report/commitment';

        $teachers = DB::table('tbl_teachers')->select('ID', 'TheName')->orderBy('TheName', 'ASC')->get();
        $academic_years = DB::table('academic_years')->orderBy('id', 'asc')->get();

        return view('back.reports.teacher_commitment.index' , compact('pageNameAr' , 'pageNameEn', 'teachers', 'academic_years'));
    }

    // start datatable group
    public function datatable(Request $request)
    {
        $academic_year = $request->academic_year;
        $from = Carbon::parse($request->from) ?? null;
        $to = Carbon::parse($request->to) ?? null;
        $diffMonth = $from->diffInMonths($to);

        $query = DB::table('tbl_groups')
                    ->leftJoin('tbl_groups_classes', 'tbl_groups_classes.GroupID', 'tbl_groups.ID')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_groups.TeacherID')
                    ->leftJoin('academic_years', 'academic_years.id', 'tbl_groups.academic_year')
                    ->select(
                        'tbl_groups.ID as groupId',
                        'tbl_groups.GroupName as groupName',
                        'tbl_groups.ClassNo1',
                        
                        'tbl_groups_classes.ClassNumber as classNumber', 
                        'tbl_groups_classes.TheStatus as classesStatus', 

                        'tbl_teachers.TheName as teacherName', 
                        
                        'academic_years.name as academicYearName',
                        DB::raw('COUNT(tbl_groups_classes.ClassNumber) as totalClasses')
                    )
                    ->groupBy('tbl_groups.ID')
                    ;


        if ($from && $to) {
            $query->whereBetween('tbl_groups_classes.TheDate', [$from, $to]);
        } elseif ($from) {
            $query->where('tbl_groups_classes.TheDate', '>=', $from);
        } elseif ($to) {
            $query->where('tbl_groups_classes.TheDate', '<=', $to);
        }
        
        if($academic_year){
            $query->where('tbl_groups.academic_year', $academic_year);
        }
        
        $all = $query->get();

        return DataTables::of($all)
                ->addColumn('ClassNo1', function($res) use ($diffMonth){
                    return ($res->ClassNo1 * $diffMonth);
                })  
                ->addColumn('totalClasses', function($res) use ($diffMonth){
                    if($res->totalClasses == ($res->ClassNo1 * $diffMonth)){
                        return '<span class="badge badge-success" style="font-size:110% !important;width: 40%;">' . e($res->totalClasses) . '</span>';

                    }else if( $res->totalClasses > ($res->ClassNo1 * $diffMonth)){
                        return '<span class="badge badge-primary" style="font-size:110% !important;width: 40%;">' . e($res->totalClasses) . '</span>';

                    }else if( $res->totalClasses < ($res->ClassNo1 * $diffMonth)){
                        return '<span class="badge badge-warning" style="font-size:110% !important;width: 40%;">' . e($res->totalClasses) . '</span>';
                    }
                    return ($res->totalClasses * $diffMonth);
                })  
                ->addColumn('diffMonth', function() use ($diffMonth) {
                    return $diffMonth;
                })
                ->addColumn('percentage', function($res) use ($diffMonth) {
                    return display_number( ($res->totalClasses / ($res->ClassNo1 * $diffMonth)) * 100 ) . ' %';
                })
                ->rawColumns(['ClassNo1', 'totalClasses', 'percentage'])
                ->toJson();
    }
    // end datatable group

}