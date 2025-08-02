<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupsController extends Controller
{
    public function index()
    {                              
        $pageNameAr = 'المجموعات التعليمية';
        $pageNameEn = 'groups';
        $class_rooms = DB::table('tbl_years_mat')->select('ID', 'TheYear')->distinct()->orderBy('TheYear', 'asc')->get();

        $subjects = DB::table('tbl_years_mat')
                        ->select('ID', 'TheMat', 'TheFullName')
                        ->distinct()
                        ->orderBy('TheMat', 'asc')
                        ->get();

                        //return $subjects;
        $types_of_education = DB::table('tbl_langs')
                                ->where('status', 1)
                                ->orderBy('LangName', 'asc')
                                ->select('LangID', 'LangName')
                                ->where('status', 1)
                                ->get();

        $academic_years = DB::table('academic_years')->orderBy('id', 'asc')->get();

        return view('back.groups.index' , compact('pageNameAr' , 'pageNameEn', 'class_rooms', 'subjects', 'types_of_education', 'academic_years'));
    }

    // start store group
    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'GroupName' => 'required|string|max:100',
                'OpenDate' => 'nullable|date',
                'CloseDate' => 'nullable|date',
                'ClassType' => 'required|string',
                'YearID' => 'required|integer|exists:tbl_years_mat,ID',
                'TeacherID' => 'required|integer|exists:tbl_teachers,ID',
                'TheLangID' => 'required|integer|exists:tbl_langs,LangID',
                'TheTestType' => 'required|string',
                'ClassNo1' => 'required|integer|min:0',
                'ThePrice' => 'required|numeric|min:0',
                'TheNotes' => 'nullable|string',
                'GroupTeacherPayType' => 'required|in:نسبة,قيمة ثابتة',
                'GroupStaticValue' => 'nullable|numeric|min:0',
                'GroupExtraValue' => 'nullable|numeric|min:0',
                'GroupMiniStudents' => 'nullable|numeric|min:0',                
                
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'date' => ':attribute يجب ان يكون تاريخ.',
                'unique' => ':attribute مستخدم من قبل.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'integer' => ':attribute يجب ان يكون رقم.',
                'numeric' => ':attribute يجب ان يكون رقم.',
                'exists' => ':attribute غير موجود في قاعدة البيانات.',
            ],[
                'GroupName' => 'إسم المجموعة',
                'OpenDate' => 'تاريخ الإفتتاح',
                'CloseDate' => 'تاريخ الإغلاق',
                'ClassType' => 'الباقة',
                'YearID' => 'المادة الدراسية',
                'TeacherID' => 'المدرس',
                'TheLangID' => 'نظام التعليم',
                'TheTestType' => 'نظام الإختبارات',
                'ClassNo1' => 'عدد حصص متوقع',
                'ThePrice' => 'السعر',
                'TheNotes' => 'ملاحظات',
                'GroupTeacherPayType' => 'النظام',
                'GroupStaticValue' => 'قيمة ثابتة',
                'GroupExtraValue' => 'قيمة الإضافي',
                'GroupMiniStudents' => 'الحد الأدني للقيمة الثابتة',
            ]);



            // start check if request -> GroupTeacherPayType is equal to 'نسبة' or 'قيمة ثابتة'
            if(request('GroupTeacherPayType') === 'قيمة ثابتة'){
                if(
                    !request('GroupStaticValue') || request('GroupStaticValue') == 0 && 
                    !request('GroupExtraValue') || request('GroupExtraValue') == 0 && 
                    !request('GroupMiniStudents') || request('GroupMiniStudents') == 0 

                ){ return response()->json(['errorStaticValue' => 'لا يوجد قيمة ثابتة.']);}
            }
            // end check if request -> GroupTeacherPayType is equal to 'نسبة' or 'قيمة ثابتة'


            // start check if group created before based on GroupName ,TeacherID ,ClassType ,TheStatus -> مفتوحة 
            $groupRel = DB::table('tbl_groups')
                            ->where('GroupName', request('GroupName'))
                            ->where('TeacherID', request('TeacherID'))                            
                            ->where('ClassType', request('ClassType'))                            
                            ->where('TheStatus', 'مفتوحة')
                            ->first();
            // end check if group created before based on GroupName ,TeacherID ,ClassType ,TheStatus -> مفتوحة 

                    


            if($groupRel){
                return response()->json(['founded' => 'تمت إضافة هذه المجموعة مسبقًا لنفس 👨‍🏫 المدرس، ونفس 💼 نظام الحساب، ونفس 📦 الباقة.']);
                
            }else{
                $data = request()->except(['_token', 'GroupPercentageValue']);
                $data['TheStatus'] = 'مفتوحة';
                $data['academic_year'] = GetAcademicYaer();                
                $data['OpenDate'] = request('OpenDate') ?? now();                
                $data['CloseDate'] = request('CloseDate') ?? null;                
                $data['GroupTeacherPayType'] = request('GroupTeacherPayType') ;
                
                if(request('GroupTeacherPayType') == 'قيمة ثابتة'){
                    $data['GroupStaticValue'] = request('GroupStaticValue');
                }else{
                    $data['GroupStaticValue'] = 0;
                }
                
                $data['GroupExtraValue'] = request('GroupExtraValue') ? request('GroupExtraValue') : 0 ;
                $data['GroupMiniStudents'] = request('GroupMiniStudents') ? request('GroupMiniStudents') : 0 ;

                DB::table('tbl_groups')->insert($data);
            }
        }
    }
    // end store group


    public function edit($id){
        if(request()->ajax()){
            $find = DB::table('tbl_groups')->where('ID', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'GroupName' => 'required|string|max:100',
                'ClassNo1' => 'required|integer|min:0',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'GroupName' => 'إسم المجموعة',
                'ClassNo1' => 'عدد حصص متوقع',
            ]);

            DB::table('tbl_groups')->where('ID', $id)->update([
                'GroupName' => request('GroupName'),
                'ClassNo1' => request('ClassNo1'),
            ]);
        }
    }


    // start destroy group
    public function destroy($id){
        $students = DB::table('tbl_groups_students')->where('GroupID', $id)->count();
        if($students > 0){
            return response()->json(['founded' => 'لا يمكن حذف هذا المجموعة لوجود طلاب في هذة المجموعة']);
        }else{
            DB::table('tbl_groups')->where('ID', $id)->delete();
        }
    }
    // end destroy group
    
    
    // start close_group
    public function close_group(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'CloseDate' => 'required|date',
            ],[
                'required' => ':attribute مطلوب.',
                'date' => ':attribute غير صحيح.',    
            ],[
                'CloseDate' => 'تاريخ الإغلاق',
            ]);

            DB::table('tbl_groups')->where('ID', $id)->update([
                'TheStatus' => 'مغلقة',
                'CloseDate' => request('CloseDate'),
            ]);
        }
    }
    // end close_group


    // start datatable group
    public function datatable(Request $request)
    {
        $academic_year = $request->academic_year;
        $from = $request->from ?? null;
        $to = $request->to ?? null;

        $query = DB::table('tbl_groups')
                    ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_groups.TeacherID')
                    ->leftJoin('tbl_langs', 'tbl_langs.LangID', 'tbl_groups.TheLangID')
                    ->leftJoin('academic_years', 'academic_years.id', 'tbl_groups.academic_year')
                    ->select(
                        'tbl_groups.*',
                        'tbl_years_mat.ID as idSubject', 'tbl_years_mat.TheFullName as TheFullNameSubject',
                        'tbl_teachers.TheName as TeacherName',
                        'tbl_langs.LangName',
                        'academic_years.name as academicYearName'
                    );

        if ($from && $to) {
            $query->whereBetween('tbl_groups.OpenDate', [$from, $to]);
        } elseif ($from) {
            $query->where('tbl_groups.OpenDate', '>=', $from);
        } elseif ($to) {
            $query->where('tbl_groups.OpenDate', '<=', $to);
        }
        
        if($academic_year){
            $query->where('tbl_groups.academic_year', $academic_year);
        }
        
        $all = $query->get();
                    
        return DataTables::of($all)
            ->addColumn('ID', function($res){
                return '#'.$res->ID;
            })      
            ->addColumn('GroupName', function($res){
                if($res->TheStatus == 'مغلقة'){
                    return '<span class="badge badge-danger" style="font-size: 100% !important;">'.$res->GroupName.'</span>';
                }else{
                    return '<span class="">'.$res->GroupName.'</span>';
                }
            })      
            ->addColumn('TheNotes', function($res){
                return '<span class="" data-bs-toggle="popover" data-bs-placement="bottom" title="'.$res->TheNotes.'">
                            '.Str::limit($res->TheNotes, 20).'
                        </span>';
            })      
            ->addColumn('action', function($res){
                return '
                    '.( $res->TheStatus != 'مغلقة' ? '
                            <button class="btn btn-sm btn-dark close_group" data-effect="effect-scale" data-toggle="modal" href="#closeGroupForm" data-placement="top" data-toggle="tooltip" title="إغلاق المجموعة نهائيا" res_id="'.$res->ID.'" group_name="'.$res->GroupName.'">
                                <i class="fas fa-lock"></i>
                            </button>
                        ' : '').'

                    <button type="button" class="btn btn-sm btn-danger delete" data-placement="top" data-toggle="tooltip" title="حذف المجموعة" res_id="'.$res->ID.'" group_name="'.$res->GroupName.'">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                            
                    <button class="btn btn-sm btn-primary edit" data-effect="effect-scale" data-toggle="modal" href="#editForm" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="'.$res->ID.'">
                        <i class="fas fa-marker"></i>
                    </button>
                    
                    <button type="button" class="btn btn-sm btn-success show_students" data-effect="effect-scale" data-toggle="modal" href="#modalStudents" data-placement="top" data-toggle="tooltip" title="عرض الطلاب" years_mat_id="'.$res->idSubject.'" group_id="'.$res->ID.'">
                        <i class="fas fa-users"></i>
                    </button>

                    <a href="'.url('groups-sessions').'/'.$res->ID.'" target="_blank" class="btn btn-sm btn-purple" data-effect="effect-scale" data-placement="top" data-toggle="tooltip" title="الحصص" res_id="'.$res->ID.'">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </a>
                ';

                //<button class="btn btn-sm btn-secondary" data-placement="top" data-toggle="tooltip" title="التقييمات" res_id="'.$res->ID.'">
                //    <i class="fas fa-award"></i>
                //</button>
                
            })
            ->rawColumns(['GroupName', 'TheNotes', 'action'])
            ->toJson();
    }
    // end datatable group









    ///////////////////////////////// start عرض الطلاب وحفظ الطلاب في جروب ما /////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // show_students طلاب المجموعة المتنمين لمجموعه ما
        public function show_students($id, $group)
        {
            if(request()->ajax()){
                $find = DB::table('tbl_students_years_mat')
                            ->where('YearID', $id)
                            ->join('tbl_students', 'tbl_students.ID', 'tbl_students_years_mat.StudentID')
                            ->join('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                            ->select(
                                'tbl_students_years_mat.*', 
                                'tbl_students.ID as studentId', 'tbl_students.TheName as studentName',
                                'tbl_parents.TheName0 as parentName'
                            )
                            ->orderBy('tbl_students.TheName', 'asc')
                            ->get();

                $groupData = DB::table('tbl_groups')
                            ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                            ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_groups.TeacherID')
                            ->leftJoin('teacher_accounting_types', 'teacher_accounting_types.teacher', 'tbl_teachers.ID')
                            ->leftJoin('tbl_langs', 'tbl_langs.LangID', 'tbl_groups.TheLangID')
                            ->leftJoin('academic_years', 'academic_years.id', 'tbl_groups.academic_year')
                            ->where('tbl_groups.ID', $group)
                            ->select(
                                'tbl_groups.*',
                                'tbl_years_mat.ID as idSubject', 'tbl_years_mat.TheFullName as TheFullNameSubject',
                                'tbl_teachers.TheName as TeacherName',
                                'teacher_accounting_types.static_value', 'teacher_accounting_types.percentage_value', 'teacher_accounting_types.tax',
                                'tbl_langs.LangName',
                                'academic_years.name as academicYearName'
                            )
                            ->first();

                $studentsChecked = DB::table('tbl_groups_students')->where('GroupID', $group)
                                        ->select('StudentID as stId', 'DiscountValue', 'TeacherValue')
                                        ->get();

                //dd($studentsChecked);

                return response()->json([
                    'findStudents' => $find, 
                    'group' => $groupData, 
                    'studentsChecked' => $studentsChecked
                ]);
            }
            return view('back.welcome');
        }


        //store_students_to_group
        public function store_students_to_group(Request $request)
        {
            //dd(request()->all());

            if (request()->ajax()){
                $this->validate($request , [
                    'GroupID' => 'required|integer|exists:tbl_groups,ID',
                    
                    'StudentID' => 'nullable|integer|exists:tbl_students,ID',
                    
                    'DiscountValue' => 'nullable|numeric|min:0|max:100',
                    
                    'TeacherValue' => 'nullable|numeric|min:0|max:100',
                ],[
                    'required' => ':attribute مطلوب.',
                    'max' => ':attribute أكبر من القيمة المطلوبة.',
                    'min' => ':attribute أقل من القيمة المطلوبة.',
                    'integer' => ':attribute يجب ان يكون رقم.',
                    'numeric' => ':attribute يجب ان يكون رقم.',
                    'exists' => ':attribute غير موجود في قاعدة البيانات.',
                ],[
                    'GroupID' => 'المجموعة',
                    'StudentID' => 'الطالب',
                    'DiscountValue' => 'نسبه خصم الطالب',
                    'TeacherValue' => 'نسبه المدرس',
                ]);


                $group = DB::table('tbl_groups')->where('ID', request('GroupID'))->first();
                //dd($group);


                //if(request('TeacherValueStatic') && !request('TeacherValuePercentage')){

                //}


                //if($group->GroupTeacherPayType == 'نسبة'){

                //}else{

                //}



                $students = json_decode($request->students);
                foreach($students as $student){

                    DB::table('tbl_groups_students')->updateOrInsert(
                        [
                            'GroupID' => request('GroupID'),
                            'StudentID' => $student->student_id,
                        ],[
                        'GroupID' => request('GroupID'), 
                        
                        'StudentID' => $student->student_id, 
                        'DiscountValue' => $student->discount, 
                        
                        'TeacherValue' => request('TeacherValuePercentage') ?? 0, 
                        'TeacherTax' => request('TeacherTax') ?? 0, 
                        'academic_year' => GetAcademicYaer(), 
                    ]);
                }
            }
        }


        // start remove all students on this group
        public function remove_all_students_by_group($group){
            DB::table('tbl_groups_students')->where('GroupID', $group)->delete();
        }
        // end remove all students on this group


        // start remove one student on this group by group and student_id
        public function remove_one_student($group, $student_id){
            DB::table('tbl_groups_students')->where('GroupID', $group)->where('StudentID', $student_id)->delete();
        }
        // end remove all students on this group

    ///////////////////////////////// end عرض الطلاب وحفظ الطلاب في جروب ما /////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
