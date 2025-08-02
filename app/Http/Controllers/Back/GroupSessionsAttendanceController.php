<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class GroupSessionsAttendanceController extends Controller
{
    public function index($groupId, $sessionId)
    {                
        $groupInfo = DB::table('tbl_groups')->where('ID', $groupId)->first();
        $sessionInfo = DB::table('tbl_groups_classes')->where('ID', $sessionId)->first();
        $pageNameAr = 'تفقد الحضور والغياب للطلاب 🎓📋';
        $pageNameEn = 'groups-sessions/attendance';
        $countStudents = DB::table('tbl_groups_students')->where('tbl_groups_students.GroupID', $groupId)->count();
        

        //$studentsAttBefore = DB::table('tbl_groups_classes_att')->where('ClassID', $sessionId)->get();
        //$studentsAtt = [];
        //foreach ($studentsAttBefore as $att) {
        //    $studentsAtt[$att->StudentID] = $att->TheStatus;
        //}

        //dd($studentsAtt);

        if($groupInfo){
            return view('back.groups_sessions_attendance.index' , compact('pageNameAr' , 'pageNameEn', 'groupId', 'sessionId', 'groupInfo', 'sessionInfo', 'countStudents'));
        }else{
            return redirect('/');
        }
    }

    public function store(Request $request, $group_id ,$session_id)
    {
        if (request()->ajax()){


            //$this->validate($request , [
            //    'TheDate' => 'required|date',
            //],[
            //    'required' => ':attribute مطلوب.',
            //    'date' => ':attribute غير صحيح.',
            //],[
            //    'TheDate' => 'تاريخ الحصة',
            //]);


            DB::transaction(function() use($group_id, $session_id) {
                $groupInfo = DB::table('tbl_groups')->where('ID', $group_id)->first();

                foreach (request('studentId') as $key => $studentId) {
                    $status = request('studentStatus')[$key];

                    $existing = DB::table('tbl_groups_classes_att')
                        ->where('GroupID', $group_id)
                        ->where('ClassID', $session_id)
                        ->where('StudentID', $studentId)
                        ->first();

                    if ($existing) {
                        DB::table('tbl_groups_classes_att')
                            ->where('ID', $existing->ID)
                            ->update([
                                'TheStatus' => $status,
                            ]);
                    } else {
                        DB::table('tbl_groups_classes_att')->insert([
                            'GroupID' => $group_id,
                            'ClassID' => $session_id,
                            'StudentID' => $studentId,
                            'TheStatus' => $status,
                            'GroupPrice' => $groupInfo->ThePrice,

                            'S_DisPre' => '0',
                            'S_DisAmount' => '0',
                            'S_FinalAmount' => '0',
                            'TeacherID' => $groupInfo->TeacherID,
                            'T_Pre' => '0',
                            'T_FinalAmount' => '0',
                            'IsExtra' => $groupInfo->GroupExtraValue > 0 ? 1 : 0,

                            'academic_year' => GetAcademicYaer(),
                        ]);
                    }
                }

                DB::table('tbl_groups_classes')->where('ID', $session_id)->update(['TheStatus' => 'مؤكد']);
            });

        }
    }

    public function close_open_session($sessionId){
        $session = DB::table('tbl_groups_classes')->where('ID', $sessionId)->first();
        
        if($session){
            if($session->TheStatus == 'مؤكد'){
                DB::table('tbl_groups_classes')->where('ID', $sessionId)->update([ 'TheStatus' => 'غير مؤكد', ]);
                return response()->json(['success' => '⚠️ تم إلغاء تأكيد الحصة بنجاح ❌']);

            }else{
                DB::table('tbl_groups_classes')->where('ID', $sessionId)->update([ 'TheStatus' => 'مؤكد', ]);
                return response()->json(['success' => '✅ تم تأكيد الحصة بنجاح 🎉']);
            }
        }
    }
    
    public function destroy($id){
        $sessions = DB::table('tbl_groups_classes_att')->where('ClassID', $id)->count();
        
        if($sessions > 0){
            return response()->json(['founded' => 'لا يمكن حذف الحصة']);

        }else{
            DB::table('tbl_groups_classes')->where('ID', $id)->delete();
        }
    }

    public function datatable($groupId, $sessionId)
    {
        $studentsAttBefore = DB::table('tbl_groups_classes_att')->where('ClassID', $sessionId)->get();
        $studentsAtt = [];
        foreach ($studentsAttBefore as $att) {
            $studentsAtt[$att->StudentID] = $att->TheStatus;
        }


        $all = DB::table('tbl_groups_students')
                ->where('tbl_groups_students.GroupID', $groupId)
                ->leftJoin('tbl_students', 'tbl_students.ID', 'tbl_groups_students.StudentID')
                ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                ->leftJoin('academic_years', 'academic_years.id', 'tbl_groups_students.academic_year')
                ->select(
                    'tbl_groups_students.*',
                    'tbl_students.TheName as studentName',
                    'tbl_parents.TheName0 as parentName', 
                    'academic_years.name as academicYearName'
                )
                ->get();

        return DataTables::of($all, $studentsAtt)
        ->addColumn('delete', function($res){
            return '
                    <button type="button" class="btn btn-sm btn-danger delete" data-placement="top" data-toggle="tooltip" title="حذف الطالب من العرض">
                        <i class="fa fa-trash-alt"></i>
                    </button>';
        }) 
        ->addColumn('studentName', function($res){
            return '<strong>'.$res->studentName.' '.$res->parentName.'</strong>
                    <input type="hidden" name="studentId[]" value="'.$res->StudentID.'" value="'.$res->studentName.' '.$res->parentName.'">';
        }) 
        ->addColumn('studentStatus', function($res) use ($studentsAtt) {
            $status = $studentsAtt[$res->StudentID] ?? '';
            $selectedPresent = $status == 'حاضر' ? 'selected' : '';
            $selectedAbsent = $status == 'غائب' ? 'selected' : '';
            $selectedAbsentPaid = $status == 'غائب/مدفوع' ? 'selected' : '';
            $selectedDisabled = $status == '' ? 'selected' : '';

            return '
                <select class="form-control studentStatus" name="studentStatus[]" style="height: 20px !important;margin: 2px 0 3px;">
                    <option disabled '.($selectedDisabled ? 'selected' : '').'>📌 حالة الحضور للطالب</option>
                    <option value="حاضر" '.$selectedPresent.'>حاضر</option>
                    <option value="غائب" '.$selectedAbsent.'>غائب</option>
                    <option value="غائب/مدفوع" '.$selectedAbsentPaid.'>غائب/مدفوع</option>
                </select>';
        }) 
        ->rawColumns(['delete', 'studentName', 'studentStatus'])
        ->toJson();
    }
}