<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class getByAjaxController extends Controller
{
    // start get all teachers by years mat
        public function get_teachers_by_years_mat($id){
            $teachers = DB::table('tbl_teachers_years_mat')
                            ->where('tbl_teachers_years_mat.YearID', $id)
                            ->join('tbl_teachers', 'tbl_teachers.ID', '=', 'tbl_teachers_years_mat.TeacherID')
                            ->select('tbl_teachers.ID as teacherId', 'tbl_teachers.TheName as teacherName')
                            ->get();

                            //dd($teachers);
            return response()->json(['teachers' => $teachers]);
        }
    // end get all teachers by years mat
    
    
    // start get_teacher_accounting_type by teacher id
        public function get_teacher_accounting_type($id){
            $teacher = DB::table('teacher_accounting_types')->where('teacher', $id)->first();

                            //dd($teacher);
            if (!$teacher) {
                return response()->json(['teacher_error' => 'Teacher not found']);
            }
        
            return response()->json(['teacher' => $teacher]);
        }
    // end get_teacher_accounting_type by teacher id
}
