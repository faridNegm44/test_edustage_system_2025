<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\ClientsAndSuppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportsTeacherStudentsClassesController extends Controller
{
    public function index()
    {         
        //if((userPermissions()->clients_report_view)){
            $pageNameAr = '📚 كشف حصص الطلاب 🎓';        
            $teachers = DB::table('tbl_teachers')->select('ID', 'TheName')->orderBy('TheName', 'asc')->get();   
            
            return view('back.reports.teacher_students_classes.index' , compact('pageNameAr', 'teachers'));
	
        //}else{
        //    return redirect('/')->with(['notAuth' => 'عذرًا، ليس لديك صلاحية لتنفيذ طلبك']);
        //}  
                  
    }
    
    public function result_pdf(Request $request)
    {                   
        $pageNameAr = 'سجل حضور وغياب – أولاد ولي الأمر'; 

        $from = $request->from ? date('Y-m-d', strtotime($request->from)) : null;
        $to = $request->to ? date('Y-m-d', strtotime($request->to)) : null;

        $query = DB::table('tbl_groups_classes_att')
                    ->whereIn('tbl_groups_classes_att.GroupID', request('groups'))
                    ->leftJoin('tbl_groups', 'tbl_groups.ID', 'tbl_groups_classes_att.GroupID')
                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                    ->leftJoin('tbl_groups_classes', 'tbl_groups_classes.ID', 'tbl_groups_classes_att.ClassID')
                    
                    ->whereIn('tbl_groups_classes_att.StudentID', request('students'))
                    ->leftJoin('tbl_students', 'tbl_students.ID', 'tbl_groups_classes_att.StudentID')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_students.teacherID')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_groups.TeacherID')
                    
                    ->leftJoin('academic_years', 'academic_years.id', 'tbl_groups_classes_att.academic_year')
                    ->select(
                        'tbl_groups_classes_att.StudentID as attendanceStudentID',
                        'tbl_groups_classes_att.TheStatus as attendanceStatus',
                        
                        'tbl_groups_classes.ClassNumber as classNumber',
                        'tbl_groups_classes.TheDate as classDate',
                        
                        'tbl_groups.GroupName as groupName',
                        'tbl_years_mat.TheFullName as matName',
                        
                        'tbl_students.TheName as studentName',
                        
                        'tbl_teachers.TheName', 
                        'tbl_teachers.TheName as teacherName', 
                        
                        'academic_years.name as academicYearName'
                    )
                    //->orderBy('tbl_students.TheName', 'asc')
                    ;

        if ($from && $to) {
            $query->whereBetween('tbl_groups_classes.TheDate', [$from, $to]);
        } elseif ($from) {
            $query->where('tbl_groups_classes.TheDate', '>=', $from);
        } elseif ($to) {
            $query->where('tbl_groups_classes.TheDate', '<=', $to);
        }
                

        $results = $query->get();       

        //return $results;

        if(count($results) == 0){
            return redirect()->back()->with('notFound', 'لا توجد بيانات مطابقة لنتيجة البحث.');
        }else{
            return view('back.reports.teacher_students_classes.pdf' , compact('pageNameAr', 'results', 'from', 'to'));
        }
    }
}