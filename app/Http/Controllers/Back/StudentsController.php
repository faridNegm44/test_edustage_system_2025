<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class StudentsController extends Controller
{
    public function index()
    {
        $pageNameAr = 'الطلاب';
        $pageNameEn = 'students';
                                    
        $types_of_education = DB::table('tbl_langs')->get();
        $nats = DB::table('tbl_nat')->where('status', 1)->get();
        $cities = DB::table('tbl_cities')->where('status', 1)->get();
        $parents = DB::table('tbl_parents')->where('TheStatus', 'مفعل')->orderBy('TheName0', 'asc')->get();

        return view('back.students.index' , compact('pageNameAr' , 'pageNameEn', 'types_of_education', 'nats', 'cities', 'parents'));
    }
    
    public function show($id)
    {
        $pageNameAr = 'بيانات الطالب: ';
        $pageNameEn = 'students';
        $find = DB::table('tbl_students')->where('ID', $id)->first();

        if($find){
            return view('back.students.show' , compact('pageNameAr' , 'pageNameEn', 'find'));
        }else{
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'ParentID' => 'required|integer|exists:tbl_parents,ID',
                'TheName' => 'required|max:70',
                'TheEmail' => 'required|email|max:70|unique:users,email',
                'ThePass' => 'nullable|string|min:6',
                'ThePhone' => 'required|numeric',
                'NatID' => 'required|integer|exists:tbl_nat,ID',
                'CityID' => 'required|integer|exists:tbl_cities,ID',
                'TheEduType' => 'required|string',
                'TheTestType' => 'required|string',
                'TheStatus' => 'required|string',
                'TheStatusDate' => 'nullable|date',
                'TheNotes' => 'nullable|string',
                'TheExplain' => 'nullable|string',
            ],[
               'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'numeric' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'exists' => ':attribute غير موجود في قاعدة البيانات.',
                'integer' => ':attribute غير صحيح.',
                'email' => ':attribute غير صالح.',
                'digits_between' => ':attribute يجب أن يكون بين :min و :max رقم.',
            ],[
                'ParentID' => 'ولي الأمر',
                'TheName' => 'اسم الطالب',
                'TheEmail' => 'البريد الإلكتروني',
                'ThePass' => 'كلمة المرور',
                'ThePhone' => 'الواتساب',
                'NatID' => 'الجنسية',
                'CityID' => 'مكان الإقامة',
                'TheStatus' => 'حالة التسجيل',
                'TheEduType' => 'نظام التعليم',
                'TheTestType' => 'نظام الاختبارات',
                'TheStatusDate' => 'تاريخ الحالة',
                'TheNotes' => 'ملاحظات',
                'TheExplain' => 'السجل الدراسي',
            ]);

            DB::transaction(function(){
                if(request('TheStatus') == 'جديد' || request('TheStatus') == 'مفعل'){
                    $activeOrNot = 1;
                }else{
                    $activeOrNot = 0;
                }

                $userId = User::insertGetId([
                    'name' => request('TheName'),
                    'email' => request('TheEmail'),
                    'password' => request('ThePass') ? Hash::make(request('ThePass')) : Hash::make('123456789##'),
                    'user_role' => null,
                    'user_status' => 5,
                    'active' => $activeOrNot,
                    'created_at' => Carbon::now(),
                    'academic_year' => GetAcademicYaer(),
                ]);

                DB::table('tbl_students')->insert([
                    'UserID' => $userId,
                    'TheDate1' => request('TheStatusDate') ?? Carbon::now()->format('Y-m-d'),
                    'TheName' => request('TheName'),
                    'ParentID' => request('ParentID'),
                    'NatID' => request('NatID'),
                    'CityID' => request('CityID'),
                    'ThePhone' => request('ThePhone'),
                    'TheEmail' => request('TheEmail'),
                    'TheEduType' => request('TheEduType'),
                    'TheTestType' => request('TheTestType'),
                    'TheExplain' => request('TheExplain'),
                    'TheNotes' => request('TheNotes'),
                    'TheStatus' => request('TheStatus'),
                    'TheStatusDate' => request('TheStatusDate') ?? Carbon::now()->format('Y-m-d'),
                    'TheLangID' => 0,
                    'academic_year' => GetAcademicYaer(),
                ]);
            });
        }
    }

    public function edit($id)
    {
        if(request()->ajax()){
            $find = DB::table('tbl_students')->where('UserID', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'ParentID' => 'required|integer|exists:tbl_parents,ID',
                'TheName' => 'required|max:70',
                'TheEmail' => 'required|email|max:70|unique:users,email,'.$id,
                'ThePass' => 'nullable|string|min:6',
                'ThePhone' => 'required|numeric',
                'NatID' => 'required|integer|exists:tbl_nat,ID',
                'CityID' => 'required|integer|exists:tbl_cities,ID',
                'TheEduType' => 'required|string',
                'TheTestType' => 'required|string',
                'TheStatus' => 'required|string',
                'TheStatusDate' => 'nullable|date',
                'TheNotes' => 'nullable|string',
                'TheExplain' => 'nullable|string',
            ],[
               'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'numeric' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'exists' => ':attribute غير موجود في قاعدة البيانات.',
                'integer' => ':attribute غير صحيح.',
                'email' => ':attribute غير صالح.',
                'digits_between' => ':attribute يجب أن يكون بين :min و :max رقم.',
            ],[
                'ParentID' => 'ولي الأمر',
                'TheName' => 'اسم الطالب',
                'TheEmail' => 'البريد الإلكتروني',
                'ThePass' => 'كلمة المرور',
                'ThePhone' => 'الواتساب',
                'NatID' => 'الجنسية',
                'CityID' => 'مكان الإقامة',
                'TheStatus' => 'حالة التسجيل',
                'TheEduType' => 'نظام التعليم',
                'TheTestType' => 'نظام الاختبارات',
                'TheStatusDate' => 'تاريخ الحالة',
                'TheNotes' => 'ملاحظات',
                'TheExplain' => 'السجل الدراسي',
            ]);

            DB::transaction(function() use($id) {
                if(request('TheStatus') == 'جديد' || request('TheStatus') == 'مفعل'){
                    $activeOrNot = 1;
                }else{
                    $activeOrNot = 0;
                }

                $findInUserTable = DB::table('users')->where('id', $id)->first();

                DB::table('users')->where('id', $id)->update([
                    'name' => request('TheName'),
                    'email' => request('TheEmail'),
                    'password' => request('ThePass') ? Hash::make(request('ThePass')) : $findInUserTable->password,
                    'active' => $activeOrNot,
                    'updated_at' => Carbon::now(),
                ]);

                DB::table('tbl_students')->where('UserID', $id)->update([
                    'TheDate1' => request('TheStatusDate') ?? Carbon::now()->format('Y-m-d'),
                    'TheName' => request('TheName'),
                    'ParentID' => request('ParentID'),
                    'NatID' => request('NatID'),
                    'CityID' => request('CityID'),
                    'ThePhone' => request('ThePhone'),
                    'TheEmail' => request('TheEmail'),
                    'TheEduType' => request('TheEduType'),
                    'TheTestType' => request('TheTestType'),
                    'TheExplain' => request('TheExplain'),
                    'TheNotes' => request('TheNotes'),
                    'TheStatus' => request('TheStatus'),
                    'TheStatusDate' => request('TheStatusDate') ?? Carbon::now()->format('Y-m-d'),
                    'TheLangID' => 0,
                ]);
            });   
        }
    }

    public function destroy($id)
    {
        if(request()->ajax()){
            $foundedData = DB::table('tbl_students_years_mat')->where('StudentID', $id)->first();

            if($foundedData){
                return response()->json(['foundedData' => 'لا يمكن حذف الطالب لأنه مسجل له رغبات حالياً 🎓📝']);
            }else{
                DB::transaction(function () use ($id){
                    $find = DB::table('tbl_students')->where('ID', $id)->first();

                    DB::table('tbl_students')->where('ID', $id)->delete();
                    DB::table('users')->where('id', $find->UserID)->delete();
                });
            }
        }
        //return view('back.welcome');
    }


    ///////////////////////////////////////////////  datatable  ////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function datatable()
    {        
        $all = DB::table('tbl_students')
                    ->leftJoin('tbl_nat', 'tbl_nat.ID', 'tbl_students.NatID')
                    ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_students.ParentID')
                    ->leftJoin('tbl_cities', 'tbl_cities.ID', 'tbl_students.CityID')
                    ->leftJoin('academic_years', 'academic_years.id', 'tbl_students.academic_year')
                    ->select(
                        'tbl_students.*', 
                        'tbl_parents.TheName0 as parentName', 
                        'tbl_nat.TheName as NatName', 
                        'tbl_cities.TheCity as CityName',
                        'academic_years.name as academicYearName'
                    )
                    ->get();

        return DataTables::of($all)
            ->addColumn('TheName', function($res){
                return '<strong>
                            <a href="'.url('students/show/'.$res->ID).'" target="_blank">'.$res->TheName.' '.$res->parentName.'</a>
                        </strong>';
            }) 
            ->addColumn('nat_city', function($res){
                return '<div>
                            <span style="margin: 0 5px !important;">'.$res->NatName.'</span>
                            <span style="margin: 0 5px !important;">'.$res->CityName.'</span>
                        </div>';
            }) 
            ->addColumn('ID', function($res){
                return '<strong>'.$res->ID.'</strong>';
            }) 
            ->addColumn('phones', function($res){
                $phones = '
                    <a class="ThePhone1 text-right text-primary" href="tel:'.$res->ThePhone.'" target="_blank">
                        '.$res->ThePhone.'
                    </a>
                ';

                return $phones;
            }) 
            
            ->addColumn('TheStatus', function($res){
                if($res->TheStatus == 'جديد'){
                    return '<div class="badge badge-dark text-white">جديد</div>';
                }
                elseif($res->TheStatus == 'مفعل'){
                    return '<div class="badge badge-success text-white">مفعل</div>';
                }
                elseif($res->TheStatus == 'غير مفعل'){
                    return '<div class="badge badge-danger text-white">غير مفعل</div>';
                }
            })
            ->addColumn('action', function($res){
                return '                
                    <button class="btn btn-sm btn-outline-danger delete" data-placement="top" data-toggle="tooltip" title="حذف" student_id="'.$res->ID.'" student_name="'.$res->TheName.'" parent_name="'.$res->parentName.'">
                        <i class="fa fa-trash"></i>
                    </button>

                    <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" student_id="'.$res->UserID.'">
                        <i class="fas fa-marker"></i>
                    </button>

                    <a href="'.url('students_wishlist').'/'.$res->ID.'" target="_blank" class="btn btn-sm btn-outline-success edit favourite_subjects" data-effect="effect-scale" data-placement="top" data-toggle="tooltip" title="رغبات الطالب" res_id="'.$res->UserID.'">
                        <i class="fa fa-heart"></i>
                    </a>
                ';
            })
            ->rawColumns(['TheName', 'ID', 'nat_city', 'TheStatus', 'phones', 'action'])
            ->toJson();
    }
}