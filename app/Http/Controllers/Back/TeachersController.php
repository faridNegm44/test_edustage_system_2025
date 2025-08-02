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
use Illuminate\Support\Str;

class TeachersController extends Controller
{
    public function index()
    {
        //$foundedData = DB::table('tbl_students')->where('tbl_students.ParentID', 9098)->first();
        //dd($foundedData);

        $pageNameAr = 'المدرسون';
        $pageNameEn = 'teachers';
                                    
        $nats = DB::table('tbl_nat')->where('status', 1)->get();
        $cities = DB::table('tbl_cities')->where('status', 1)->get();
        $academic_years = DB::table('academic_years')->orderBy('id', 'asc')->get();

        return view('back.teachers.index' , compact('pageNameAr' , 'pageNameEn', 'nats', 'cities', 'academic_years'));
    }
    
    public function show($id)
    {
        $pageNameAr = 'بيانات مدرس: ';
        $pageNameEn = 'teachers';
        $find = DB::table('tbl_teachers')->where('ID', $id)->first();

        if($find){
            return view('back.teachers.show' , compact('pageNameAr' , 'pageNameEn', 'find'));
        }else{
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        if (request()->ajax())
        {
            $this->validate($request, [
                'TheName'        => 'required|string|max:70',
                'NatID'          => 'required|integer|exists:tbl_nat,ID',
                'CityID'         => 'required|integer|exists:tbl_cities,ID',
                'TheEmail'       => 'required|email|max:70|unique:users,email',
                'ThePass'        => 'nullable|string|min:6',
                'TheBirthDate'   => 'nullable|date',
                'ThePhone1'      => 'required|numeric',
                'ThePhone2'      => 'required|numeric',
                'TheCurrentJob'  => 'required|string',
                'TheExNumber'    => 'required|numeric',
                'TheMethod'      => 'nullable|string',
                'TheExExplain'   => 'nullable|string',
                'HaveLap'        => 'required|in:نعم,لا',
                'HaveHead'       => 'required|in:نعم,لا',
                'HaveNet'        => 'required|in:نعم,لا',
                'TheStatus'      => 'required|string',
                'TheStatusDate'  => 'nullable|date',
            ], [
                'required'     => ':attribute مطلوب.',
                'string'       => ':attribute غير صحيح.',
                'numeric'      => ':attribute يجب أن يكون رقمًا.',
                'integer'      => ':attribute يجب أن يكون عددًا صحيحًا.',
                'unique'       => ':attribute مستخدم من قبل.',
                'max'          => ':attribute أكبر من الحد المسموح.',
                'min'          => ':attribute يجب ألا يقل عن :min حروف.',
                'email'        => ':attribute يجب أن يكون بريدًا إلكترونيًا صحيحًا.',
                'date'         => ':attribute يجب أن يكون تاريخًا صحيحًا.',
                'in'           => ':attribute يجب أن يكون إما نعم أو لا.',
            ], [
                'TheName'        => 'اسم المدرس',
                'NatID'          => 'الجنسية',
                'CityID'         => 'مكان الإقامة',
                'TheEmail'       => 'البريد الإلكتروني',
                'ThePass'        => 'كلمة المرور',
                'TheBirthDate'   => 'تاريخ الميلاد',
                'ThePhone1'      => 'رقم الموبايل',
                'ThePhone2'      => 'رقم الواتساب',
                'TheCurrentJob'  => 'الوظيفة الحالية',
                'TheExNumber'    => 'عدد سنوات الخبرة',
                'TheMethod'      => 'المنهج',
                'TheExExplain'   => 'شرح الخبرة',
                'HaveLap'        => 'امتلاك لابتوب',
                'HaveHead'       => 'امتلاك سماعة',
                'HaveNet'        => 'امتلاك إنترنت',
                'TheStatus'      => 'حالة التسجيل',
                'TheStatusDate'  => 'تاريخ الحالة',
            ]);
            
            // start db transaction

            DB::transaction(function () {
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
                    'user_status' => 4,
                    'active' => $activeOrNot,
                    'created_at' => Carbon::now(),
                    'academic_year' => GetAcademicYaer(),
                ]);

                DB::table('tbl_teachers')->insert([
                    'UserID' => $userId,
                    'TheName' => request('TheName'),
                    'TheDate1' => request('TheStatusDate') ?? Carbon::now()->format('Y-m-d'),
                    'TheEmail' => request('TheEmail'),
                    'ThePass' => request('ThePass') ? Hash::make(request('ThePass')) : Hash::make('123456789##'),
                    'NatID' => request('NatID'),
                    'CityID' => request('CityID'),
                    'TheBirthDate' => request('TheBirthDate'),
                    'ThePhone1' => request('ThePhone1'),
                    'ThePhone2' => request('ThePhone2'),
                    'TheCurrentJob' => request('TheCurrentJob'),
                    'TheExNumber' => request('TheExNumber'),
                    'TheMethod' => request('TheMethod') ?? '',
                    'HaveEx' => request('HaveEx'),
                    'TheExExplain' => request('TheExExplain') ?? '',
                    'HaveLap' => request('HaveLap'),
                    'HaveHead' => request('HaveHead'),
                    'HaveNet' => request('HaveNet'),
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
            $find = DB::table('tbl_teachers')->where('UserID', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request, [
                'TheName'        => 'required|string|max:70',
                'NatID'          => 'required|integer|exists:tbl_nat,ID',
                'CityID'         => 'required|integer|exists:tbl_cities,ID',
                'TheEmail'       => 'required|email|max:70|unique:users,email,'.$id,
                'ThePass'        => 'nullable|string|min:6',
                'TheBirthDate'   => 'nullable|date',
                'ThePhone1'      => 'required|numeric',
                'ThePhone2'      => 'required|numeric',
                'TheCurrentJob'  => 'required|string',
                'TheExNumber'    => 'required|numeric',
                'TheMethod'      => 'nullable|string',
                'TheExExplain'   => 'nullable|string',
                'HaveLap'        => 'required|in:نعم,لا',
                'HaveHead'       => 'required|in:نعم,لا',
                'HaveNet'        => 'required|in:نعم,لا',
                'TheStatus'      => 'required|string',
                'TheStatusDate'  => 'nullable|date',
            ], [
                'required'     => ':attribute مطلوب.',
                'string'       => ':attribute غير صحيح.',
                'numeric'      => ':attribute يجب أن يكون رقمًا.',
                'integer'      => ':attribute يجب أن يكون عددًا صحيحًا.',
                'unique'       => ':attribute مستخدم من قبل.',
                'max'          => ':attribute أكبر من الحد المسموح.',
                'min'          => ':attribute يجب ألا يقل عن :min حروف.',
                'email'        => ':attribute يجب أن يكون بريدًا إلكترونيًا صحيحًا.',
                'date'         => ':attribute يجب أن يكون تاريخًا صحيحًا.',
                'in'           => ':attribute يجب أن يكون إما نعم أو لا.',
            ], [
                'TheName'        => 'اسم المدرس',
                'NatID'          => 'الجنسية',
                'CityID'         => 'مكان الإقامة',
                'TheEmail'       => 'البريد الإلكتروني',
                'ThePass'        => 'كلمة المرور',
                'TheBirthDate'   => 'تاريخ الميلاد',
                'ThePhone1'      => 'رقم الموبايل',
                'ThePhone2'      => 'رقم الواتساب',
                'TheCurrentJob'  => 'الوظيفة الحالية',
                'TheExNumber'    => 'عدد سنوات الخبرة',
                'TheMethod'      => 'المنهج',
                'TheExExplain'   => 'شرح الخبرة',
                'HaveLap'        => 'امتلاك لابتوب',
                'HaveHead'       => 'امتلاك سماعة',
                'HaveNet'        => 'امتلاك إنترنت',
                'TheStatus'      => 'حالة التسجيل',
                'TheStatusDate'  => 'تاريخ الحالة',
            ]);

            // start db transaction
            DB::transaction(function () use($id) {
                $findInUserTable = DB::table('users')->where('id', $id)->first();

                if(request('TheStatus') == 'جديد' || request('TheStatus') == 'مفعل'){
                    $activeOrNot = 1;
                }else{
                    $activeOrNot = 0;
                }

                DB::table('users')->where('id', $id)->update([
                    'name' => request('TheName'),
                    'email' => request('TheEmail'),
                    'password' => request('ThePass') ? Hash::make(request('ThePass')) : $findInUserTable->password,
                    'user_role' => null,
                    'active' => $activeOrNot,
                    'updated_at' => Carbon::now(),
                ]);

                DB::table('tbl_teachers')->where('UserID', $id)->update([
                    'TheName' => request('TheName'),
                    'TheDate1' => request('TheStatusDate') ?? Carbon::now()->format('Y-m-d'),
                    'TheEmail' => request('TheEmail'),
                    'ThePass' => request('ThePass') ? Hash::make(request('ThePass')) : $findInUserTable->password,
                    'NatID' => request('NatID'),
                    'CityID' => request('CityID'),
                    'TheBirthDate' => request('TheBirthDate'),
                    'ThePhone1' => request('ThePhone1'),
                    'ThePhone2' => request('ThePhone2'),
                    'TheCurrentJob' => request('TheCurrentJob'),
                    'TheExNumber' => request('TheExNumber'),
                    'TheMethod' => request('TheMethod') ?? '',
                    'HaveEx' => request('HaveEx'),
                    'TheExExplain' => request('TheExExplain') ?? '',
                    'HaveLap' => request('HaveLap'),
                    'HaveHead' => request('HaveHead'),
                    'HaveNet' => request('HaveNet'),
                    'TheStatus' => request('TheStatus'),
                    'TheStatusDate' => request('TheStatusDate') ?? Carbon::now()->format('Y-m-d'),
                    'academic_year' => GetAcademicYaer(),
                ]);
            });
            // end db transaction
        }
    }

    public function destroy($id)
    {
        if(request()->ajax()){
            $foundedData = DB::table('tbl_teachers_years_mat')->where('TeacherID', $id)->first();
            
            if($foundedData){
                return response()->json(['foundedData' => 'لا يمكن حذف المدرس لأنه مرتبط بصفوف ومواد دراسية يقوم بتدريسها حالياً 📚👨‍🏫']);

            }else{
                DB::transaction(function() use($id){
                    DB::table('tbl_teachers')->where('UserID', $id)->delete();
                    DB::table('users')->where('id', $id)->delete();
                });
            }
        }
    }


    ///////////////////////////////////////////////  datatable  ////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function datatable(Request $request)
    {   
        $academic_year = $request->academic_year;
        $from = $request->from ?? null;
        $to = $request->to ?? null;

        $query = DB::table('tbl_teachers')
                        ->leftJoin('tbl_nat', 'tbl_nat.ID', 'tbl_teachers.NatID')
                        ->leftJoin('tbl_cities', 'tbl_cities.ID', 'tbl_teachers.CityID')
                        ->leftJoin('academic_years', 'academic_years.id', 'tbl_teachers.academic_year')
                        ->select(
                            'tbl_teachers.*', 
                            'tbl_nat.TheName as NatName', 
                            'tbl_cities.TheCity as CityName',
                            'academic_years.name as academicYearName'
                        );

        if ($from && $to) {
            $query->whereBetween('tbl_teachers.TheDate1', [$from, $to]);
        } elseif ($from) {
            $query->where('tbl_teachers.TheDate1', '>=', $from);
        } elseif ($to) {
            $query->where('tbl_teachers.TheDate1', '<=', $to);
        }
        
        if($academic_year){
            $query->where('tbl_teachers.academic_year', $academic_year);
        }

        $all = $query->get();
                        
        return DataTables::of($all)
            ->addColumn('TheName', function($res){
                return '<strong>
                            <a href="'.url('teachers/show/'.$res->ID).'" target="_blank">'.$res->TheName.'</a>
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
                    return '<div class="badge badge-success text-white">مفعل</div>';
                }
                elseif($res->TheStatus == 'غير مفعل'){
                    return '<div class="badge badge-danger text-white">غير مفعل</div>';
                }
            })
            ->addColumn('TheExExplain', function($res){
                return '<span data-bs-toggle="popover" data-bs-placement="bottom" title="'.$res->TheExExplain.'">
                    '.Str::limit($res->TheExExplain, 40).'
                </span>';
            })     
            ->addColumn('TheMethod', function($res){
                return '<span data-bs-toggle="popover" data-bs-placement="bottom" title="'.$res->TheMethod.'">
                    '.Str::limit($res->TheMethod, 40).'
                </span>';
            })     
            ->addColumn('action', function($res){
                return '
                    <button class="btn btn-sm btn-outline-danger delete" data-placement="top" data-toggle="tooltip" title="حذف" teacher_id="'.$res->UserID.'" teacher_name="'.$res->TheName.'">
                        <i class="fa fa-trash"></i>
                    </button>

                    <a href="'.url('teacher_subjects').'/'.$res->ID.'" target="_blank" class="btn btn-sm btn-outline-success show" data-effect="effect-scale" data-placement="top" data-toggle="tooltip" title="الصفوف والمواد الدراسية الخاصة بالمدرس">
                        <i class="fas fa-layer-group"></i>
                    </a>
                    
                    <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" teacher_id="'.$res->UserID.'">
                        <i class="fas fa-marker"></i>
                    </button>
                ';                
            })
            ->rawColumns(['TheName', 'ID', 'nat_city', 'TheStatus', 'phones', 'whats', 'TheExExplain', 'TheMethod', 'action'])
            ->toJson();
    }
}
