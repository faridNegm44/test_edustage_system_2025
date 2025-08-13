<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\CrmCategories;
use App\Models\Back\CrmColumnsNames;
use App\Models\Back\CrmColumnsValues;
use App\Models\Back\Parents;
use App\Models\Back\RolesPermissions;
use App\Models\Back\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    public function index()
    {
        //$foundedData = DB::table('tbl_students')->where('tbl_students.ParentID', 9098)->first();
        //dd($foundedData);

        $pageNameAr = 'أولياء الأمور';
        $pageNameEn = 'parents';
        $crmCategories = CrmCategories::all();
        $crmNamesEmpty = CrmColumnsNames::orderBy('category', 'asc')
                                        ->orderBy('order', 'asc')
                                        ->get();
                                    
        $nats = DB::table('tbl_nat')->where('status', 1)->get();
        $cities = DB::table('tbl_cities')->where('status', 1)->get();
        $academic_years = DB::table('academic_years')->orderBy('id', 'asc')->get();

        return view('back.parents.index' , compact('pageNameAr' , 'pageNameEn', 'crmCategories', 'crmNamesEmpty', 'nats', 'cities', 'academic_years'));
    }
    
    public function show($id)
    {
        $pageNameAr = 'بيانات ولي أمر: ';
        $pageNameEn = 'parents';
        $find = DB::table('tbl_parents')->where('ID', $id)->first();

        if($find){
            return view('back.parents.show' , compact('pageNameAr' , 'pageNameEn', 'find'));
        }else{
            return redirect()->back();
        }
    }
    
    public function related_data(Request $request)
    {
        $students = DB::table('tbl_students')->where('tbl_students.ParentID', request('parent_id'))->orderBy('TheName', 'asc')->get();
                
        $groups = DB::table('tbl_groups_students')
                    ->leftJoin('tbl_students', 'tbl_students.ID', '=', 'tbl_groups_students.StudentID')
                    ->join('tbl_groups', 'tbl_groups.ID', '=', 'tbl_groups_students.GroupID')
                    ->where('tbl_students.ParentID', request('parent_id'))
                    ->select(
                        'tbl_groups.ID as groupId',
                        'tbl_groups.GroupName as groupName' 
                    )
                    ->orderBy('tbl_groups.GroupName', 'asc')
                    ->get();


        //return $students;

        if($students->count() > 0){
            return response()->json([
                'students' => $students,
                'groups' => $groups,
            ]);
        }else{
            return response()->json(['no_related' => ' لا يوجد طلاب مسجلين لولي الأمر في الوقت الحالى 👨‍👩‍👧‍👦']);
        }
    }

    public function store(Request $request)
    {
        if (request()->ajax()){

            $this->validate($request , [
                'TheName0' => 'max:70|unique:tbl_parents,TheName0',
                'TheName1' => 'required|string|max:20',
                'TheName2' => 'required|string|max:20',
                'TheName3' => 'required|string|max:20',
                'TheEmail' => 'required|string|max:50|unique:users,email',
                'ThePhone1' => 'required|numeric|unique:tbl_parents,ThePhone1',
                'ThePhone2' => 'required|numeric|unique:tbl_parents,ThePhone2',
                'NatID' => 'required|integer|exists:tbl_nat,ID',
                'CityID' => 'required|integer|exists:tbl_cities,ID',
                'TheStatus' => 'required|string',
                'TheNotes' => 'nullable|string',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'numeric' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'exists' => ':attribute غير موجود في قاعدة البيانات.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'TheName1' => 'الإسم الأول',
                'TheName2' => 'إسم الأب',
                'TheName3' => 'الكنية',
                'TheEmail' => 'البريد الإلكتروني',
                'ThePhone1' => 'الموبايل',
                'ThePhone2' => 'الواتساب',
                'NatID' => 'الجنسية',
                'CityID' => 'مكان الإقامة',
                'TheStatus' => 'حالة التسجيل',
                'TheNotes' => 'ملاحظات',
            ]);

            // start db transaction
            DB::transaction(function () {
                $name = request('TheName1').' '.request('TheName2').' '.request('TheName3');
                
                $userId = User::insertGetId([
                    'name' => $name,
                    'email' => request('TheEmail'),
                    'password' => request('ThePass') ? Hash::make(request('ThePass')) : Hash::make('123456789##'),
                    'user_role' => null,
                    'user_status' => 3,
                    'active' => 1,
                    'created_at' => Carbon::now(),
                    'academic_year' => GetAcademicYaer(),
                ]);

                DB::table('tbl_parents')->insert([
                    'ID' => $userId,
                    'TheDate1' => request('TheStatusDate') ?? Carbon::now()->format('Y-m-d'),
                    'TheEmail' => request('TheEmail'),
                    'ThePass' => request('ThePass') ? Hash::make(request('ThePass')) : Hash::make('123456789##'),
                    'TheName0' => $name,
                    'TheName1' => request('TheName1'),
                    'TheName2' => request('TheName2'),
                    'TheName3' => request('TheName3'),
                    'NatID' => request('NatID'),
                    'CityID' => request('CityID'),
                    'ThePhone1' => request('ThePhone1'),
                    'ThePhone2' => request('ThePhone2'),
                    'TheNotes' => request('TheNotes'),
                    'TheStatus' => request('TheStatus'),
                    'TheStatusDate' => request('TheStatusDate') ?? Carbon::now()->format('Y-m-d'),
                    'PrevRaseed' => 0,
                    'academic_year' => GetAcademicYaer(),
                ]);
            });
            // end db transaction
        }
    }

    public function edit($id){
        
        if(request()->ajax()){
            $find = DB::table('tbl_parents')->where('ID', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'TheName0' => 'max:70|unique:tbl_parents,TheName0,'.$id.',ID',
                'TheName1' => 'required|string|max:20',
                'TheName2' => 'required|string|max:20',
                'TheName3' => 'required|string|max:20',
                'TheEmail' => 'required|string|max:50|unique:users,email,'.$id.',ID',
                'ThePhone1' => 'required|numeric|unique:tbl_parents,ThePhone1,'.$id.',ID',
                'ThePhone2' => 'required|numeric|unique:tbl_parents,ThePhone2,'.$id.',ID',
                'NatID' => 'required|integer|exists:tbl_nat,ID',
                'CityID' => 'required|integer|exists:tbl_cities,ID',
                'TheStatus' => 'required|string',
                'TheNotes' => 'nullable|string',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'numeric' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'exists' => ':attribute غير موجود في قاعدة البيانات.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'TheName1' => 'الإسم الأول',
                'TheName2' => 'إسم الأب',
                'TheName3' => 'الكنية',
                'TheEmail' => 'البريد الإلكتروني',
                'ThePhone1' => 'الموبايل',
                'ThePhone2' => 'الواتساب',
                'NatID' => 'الجنسية',
                'CityID' => 'مكان الإقامة',
                'TheStatus' => 'حالة التسجيل',
                'TheNotes' => 'ملاحظات',
            ]);

            // start db transaction
            DB::transaction(function () use($id) {
                $name = request('TheName1').' '.request('TheName2').' '.request('TheName3');

                $findInUserTable = DB::table('users')->where('id', $id)->first();

                DB::table('users')->where('id', $id)->update([
                    'name' => $name,
                    'email' => request('TheEmail'),
                    'password' => request('ThePass') ? Hash::make(request('ThePass')) : $findInUserTable->password,
                    'user_role' => null,
                    'user_status' => 3,
                    'active' => 1,
                    'created_at' => Carbon::now(),
                    'academic_year' => GetAcademicYaer(),
                ]);

                DB::table('tbl_parents')->where('ID', $id)->update([
                    'TheDate1' => request('TheStatusDate') ?? Carbon::now()->format('Y-m-d'),
                    'TheEmail' => request('TheEmail'),
                    'ThePass' => request('ThePass') ? Hash::make(request('ThePass')) : $findInUserTable->password,
                    'TheName0' => $name,
                    'TheName1' => request('TheName1'),
                    'TheName2' => request('TheName2'),
                    'TheName3' => request('TheName3'),
                    'NatID' => request('NatID'),
                    'CityID' => request('CityID'),
                    'ThePhone1' => request('ThePhone1'),
                    'ThePhone2' => request('ThePhone2'),
                    'TheNotes' => request('TheNotes'),
                    'TheStatus' => request('TheStatus'),
                    'TheStatusDate' => request('TheStatusDate') ?? Carbon::now()->format('Y-m-d'),
                    'PrevRaseed' => 0,
                    'academic_year' => GetAcademicYaer(),
                ]);
            });
            // end db transaction
        }
    }

    public function destroy($id)
    {
        if(request()->ajax()){
            $foundedData = DB::table('tbl_students')->where('tbl_students.ParentID', $id)->first();
            
            if($foundedData){
                return response()->json(['foundedData' => 'لا يمكن حذف السجل، لأن ولي الأمر لديه طلاب مسجلين 👨‍👩‍👧‍👦📚']);

            }else{
                DB::transaction(function() use($id){
                    DB::table('tbl_parents')->where('ID', $id)->delete();
                    DB::table('users')->where('id', $id)->delete();
                });
            }
        }
        //return view('back.welcome');
    }


    ///////////////////////////////////////////////  datatable  ////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function datatable(Request $request)
    {   
        $academic_year = $request->academic_year;
        $from = $request->from ?? null;
        $to = $request->to ?? null;

        $query = Parents::leftJoin('tbl_nat', 'tbl_nat.ID', 'tbl_parents.NatID')
                        ->leftJoin('tbl_cities', 'tbl_cities.ID', 'tbl_parents.CityID')
                        ->leftJoin('academic_years', 'academic_years.id', 'tbl_parents.academic_year')
                        ->select(
                            'tbl_parents.*', 
                            'tbl_nat.TheName as NatName', 
                            'tbl_cities.TheCity as CityName',
                            'academic_years.name as academicYearName'
                        );

        if ($from && $to) {
            $query->whereBetween('tbl_parents.TheDate1', [$from, $to]);
        } elseif ($from) {
            $query->where('tbl_parents.TheDate1', '>=', $from);
        } elseif ($to) {
            $query->where('tbl_parents.TheDate1', '<=', $to);
        }
        
        if($academic_year){
            $query->where('tbl_parents.academic_year', $academic_year);
        }

        $all = $query->get();
                        
        return DataTables::of($all)
            ->addColumn('TheName0', function($res){
                return '<strong>
                            <a href="'.url('parents/show/'.$res->ID).'" target="_blank">'.$res->TheName0.'</a>
                        </strong>';
            }) 
            ->addColumn('nat_city', function($res){
                return '<div>
                            <span style="margin: 0 !important;">'.$res->NatName.'</span>
                            <span style="margin: 0 5px !important;">'.$res->CityName.'</span>
                        </div>';
            }) 
            ->addColumn('ID', function($res){
                return '<strong>'.$res->ID.'</strong>';
            }) 
            ->addColumn('phones', function($res){
                $phones = '
                    <a class="ThePhone1 text-right text-primary" href="tel:'.$res->ThePhone1.'" target="_blank">
                        <i class="fas fa-phone" style="margin: 3px;position: relative;top: 2px;font-size: 15px;"></i>
                        '.$res->ThePhone1.'
                    </a>
                ';
                            
                return $phones;
            }) 
            ->addColumn('whats', function($res){
                $phones = '
                    <a class="ThePhone2 text-right text-success d-block" href="https://wa.me/'.$res->ThePhone2.'" target="_blank">
                        <i class="fab fa-whatsapp" style="margin: 3px;position: relative;top: 2px;font-size: 15px;"></i>
                        '.$res->ThePhone2.'
                    </a>
                ';
                
                return $phones;
            }) 
            
            ->addColumn('TheStatus', function($res){
                if($res->TheStatus == 'جديد'){
                    return '<div class="badge badge-dark text-white">جديد</div>';
                }
                elseif($res->TheStatus == 'مفعل'){
                    return '<div class="badge badge-success text-white">نشط</div>';
                }
                elseif($res->TheStatus == 'غير مفعل'){
                    return '<div class="badge badge-danger text-white">معطل</div>';
                }
            })
            ->addColumn('action', function($res){
                return '
                    <button type="button" class="btn btn-sm btn-outline-dark crm_info" data-effect="effect-scale" data-toggle="modal" href="#crmModal" data-placement="top" data-toggle="tooltip" title="معلومات crm" parent_id="'.$res->ID.'">
                        <i class="fas fa-info-circle"></i>
                    </button>

                    <a href="'.url('parents/report/crm_pdf/'.$res->ID).'" target="_blank" class="btn btn-sm btn-outline-success print" data-effect="effect-scale" data-placement="top" data-toggle="tooltip" title="طباعة crm" parent_id="'.$res->ID.'">
                        <i class="fas fa-print"></i>
                    </a>

                    <button class="btn btn-sm btn-outline-danger delete" data-placement="top" data-toggle="tooltip" title="حذف" parent_id="'.$res->ID.'" parent_name="'.$res->TheName0.'">
                        <i class="fa fa-trash"></i>
                    </button>

                    <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" parent_id="'.$res->ID.'">
                        <i class="fas fa-marker"></i>
                    </button>
                ';                
            })
            ->rawColumns(['TheName0', 'ID', 'nat_city', 'TheStatus', 'phones', 'whats', 'action'])
            ->toJson();
    }






    ///////////////////////////////////////////////  crm  ///////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function crm_info($id)
    {
        if (request()->ajax()){
            $parent = Parents::where('ID', $id)->first();
            $crmNames = CrmColumnsNames::orderBy('category', 'asc')
                                        ->orderBy('order', 'asc')
                                        ->leftJoin('crm_columns_values', 'crm_columns_values.column_id', 'crm_columns_names.id')
                                        ->where('crm_columns_values.parent_id', $id)
                                        ->select(
                                            'crm_columns_names.id as crmColumnNameId',
                                            'crm_columns_names.name_ar as crmColumnName',
                                            'crm_columns_names.category as crmColumnNameCategory',
                                            'crm_columns_names.order as crmColumnNameOrder',

                                            'crm_columns_values.column_id as crmColumnValuesId',
                                            'crm_columns_values.value as crmColumnValuesValue',
                                            'crm_columns_values.parent_id as crmColumnValuesParentID',
                                        )
                                        ->get();

            $crmNamesEmpty = CrmColumnsNames::orderBy('category', 'asc')
                                            ->orderBy('order', 'asc')
                                            ->get();

                                            // dd($crmNames);

            return response()->json([
                'parent' => $parent,
                'crmNames' => $crmNames,
                'crmNamesEmpty' => $crmNamesEmpty,
                // 'crmCategories' => $crmCategories,
            ]);
        }
        return response()->json(['failed' => 'Access Denied']);
    }

    public function crm_info_update(Request $request, $id)
    {
        dd(request('columnValue'));
        $columnValue = request('columnValue');
        $parentId = request('parent_id');

        for ($i = 0; $i < count($columnValue); $i++) {
            $data = [
                'parent_id' => $parentId,
                'column_id' => ($i + 1),
                'value' => $columnValue[$i],
            ];

            CrmColumnsValues::updateOrInsert(
                ['parent_id' => $parentId, 'column_id' => ($i + 1)],
                $data
            );
        }
    }









    ///////////////////////////////////////////////  reports  ///////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function crm_pdf($id)
    {

        $parentDetails = Parents::where('ID', $id)->first();

        $nameAr = 'تقرير بيانات ولي أمر'.' - '.$parentDetails->TheName0;

        $studentDetails = DB::table('tbl_students')
                            ->leftJoin('tbl_groups_students', 'tbl_groups_students.StudentID', 'tbl_students.ID')
                            ->leftJoin('tbl_groups', 'tbl_groups.ID', 'tbl_groups_students.GroupID')
                            ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_groups.YearID')
                            ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_groups.TeacherID')
                            ->select(
                                'tbl_students.TheName as studentName', 'tbl_students.TheEmail as studentEmail', 'tbl_students.TheEduType as eduType', 'tbl_students.TheTestType as testType',
                                'tbl_groups.GroupName as groupName',
                                'tbl_teachers.TheName as teacherName',
                                'tbl_years_mat.TheFullName as fullMatName'
                            )
                            ->where('ParentID', $parentDetails->ID)
                            ->orderBy('tbl_students.TheName', 'asc')
                            ->get();

        $crmCategoriesDetails = DB::table('crm_categories')->get();

        $crmColumnsNamesDetails = DB::table('crm_columns_names')
                                    ->orderBy('category', 'asc')
                                    ->orderBy('order', 'asc')
                                    ->where('status', 1)
                                    ->get();

        $crmColumnsValues = DB::table('crm_columns_values')->where('parent_id', $parentDetails->ID)
                            ->leftJoin('crm_columns_names', 'crm_columns_names.id', 'crm_columns_values.column_id')
                            ->select(
                                'crm_columns_values.column_id as columnId', 'crm_columns_values.value',
                                'crm_columns_names.id as columnNameId', 'crm_columns_names.name_ar as nameAr'
                            )
                            ->get();

        // return $studentDetails;

        return view('back.parents.report_crm.pdf', compact('nameAr', 'parentDetails', 'studentDetails', 'crmCategoriesDetails', 'crmColumnsNamesDetails', 'crmColumnsValues'));
    }

}
