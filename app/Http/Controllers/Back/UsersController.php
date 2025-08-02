<?php

namespace App\Http\Controllers\Back;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\Back\User;
use App\Models\Back\Admin;
use App\Models\Back\RolesPermissions;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    
    public function index()
    {
        // dd();
        $pageNameAr = 'المستخدمين';
        $pageNameEn = 'users';
        $permissions = RolesPermissions::all();
        
        return view('back.users.index' , compact('pageNameAr' , 'pageNameEn', 'permissions'));
    }

    public function store(Request $request)
    {

        if (request()->ajax()){
            $this->validate($request , [
                'name' => 'required|string|max:250|unique:users,name',
                'email' => 'required|unique:users,email',
                'birth_date' => 'nullable|date' ,
                'phone' => 'nullable|numeric|unique:admins,phone',
                'nat_id' => 'nullable|min:14|numeric|unique:admins,nat_id',
                'password' => 'required|min:6',
                'confirmed_password' => 'required|min:6|same:password',
                'user_role' => 'required',
                'user_status' => 'required|in:1,2',
                'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:1500',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'numeric' => ':attribute غير صحيح.',
                'date' => ':attribute يجب ان يكون تاريخ.',
                'email' => ':attribute البريد الإلكتروني.',
                'unique' => ':attribute مستخدم من قبل.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'same' => ':attribute غير مطابقة مع كلمة المرور.',
                'mimes' => ':attribute يجب أن تكون من نوع JPG أو PNG أو JPEG أو GIF.',
                'max' => ':attribute حجمها كبير.',
            ],[
                'name' => 'إسم المستخدم',
                'email' => 'البريد الإلكتروني',
                'birth_date' => 'تاريخ الميلاد',
                'phone' => 'التليفون',
                'user_role' => 'تراخيص المستخدم',
                'user_status' => 'حالة المستخدم',
                'address' => 'العنوان',
                'nat_id' => 'الرقم القومي',
                'password' => 'كلمة المرور',
                'confirmed_password' => 'تأكيد كلمة المرور',
                'image' => 'صورة المستخدم',
            ]);


            // start DB transaction to store
            DB::transaction(function(){

                if(request()->hasFile('image')){
                    $file = request('image');
                    $name = time() . '.' .$file->getClientOriginalExtension();
                    $path = public_path('back/images/users');
                    $file->move($path , $name);
                }else{
                    $name = "df_image.png";
                }

                $userId = User::insertGetId([
                    'name' => request('name'),
                    'email' => request('email'),
                    'password' => Hash::make(request('password')),
                    'user_role' => 22,
                    'user_status' => request('user_status'),
                    'active' => request('active'),
                    'created_at' => Carbon::now(),
                ]);

                Admin::create([
                    'user_id' => $userId,
                    'gender' => request('gender'),
                    'phone' => request('phone'),
                    'birth_date' => request('birth_date'),
                    'nat_id' => request('nat_id'),
                    'address' => request('address'),
                    'notes' => request('notes'),
                    'image' => $name

                ]);
            });
            // end DB transaction to store
        }
    }

    public function edit($id)
    {
        if (request()->ajax()){
            $user = User::where('id', $id)->first();
            $userInAdminTable = Admin::where('user_id', $id)->first();

            return response()->json([
                'user' => $user,
                'userInAdminTable' => $userInAdminTable
            ]);
        }
        return response()->json(['failed' => 'Access Denied']);
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $userInAdminTable = Admin::where('user_id', $id)->first();

        if (request()->ajax()){
            $this->validate($request , [
                'name' => 'required|string|max:250|unique:users,name,'.$id,
                'email' => 'required|unique:users,email,'.$id,
                'birth_date' => 'nullable|date' ,
                'phone' => 'nullable|numeric|unique:admins,phone,'.$userInAdminTable['id'],
                'nat_id' => 'nullable|min:14|numeric|unique:admins,nat_id,'.$userInAdminTable['id'],
                'password' => 'nullable|min:6',
                'confirmed_password' => 'nullable|min:6|same:password',
                'user_role' => 'required',
                'user_status' => 'required|in:1,2',
                'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:1500',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'numeric' => ':attribute غير صحيح.',
                'date' => ':attribute يجب ان يكون تاريخ.',
                'email' => ':attribute البريد الإلكتروني.',
                'unique' => ':attribute مستخدم من قبل.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'same' => ':attribute غير مطابقة مع كلمة المرور.',
                'mimes' => ':attribute يجب أن تكون من نوع JPG أو PNG أو JPEG أو GIF.',
                'max' => ':attribute حجمها كبير.',
            ],[
                'name' => 'إسم المستخدم',
                'email' => 'البريد الإلكتروني',
                'birth_date' => 'تاريخ الميلاد',
                'phone' => 'التليفون',
                'user_role' => 'تراخيص المستخدم',
                'user_status' => 'حالة المستخدم',
                'address' => 'العنوان',
                'nat_id' => 'الرقم القومي',
                'password' => 'كلمة المرور',
                'confirmed_password' => 'تأكيد كلمة المرور',
                'image' => 'صورة المستخدم',

            ]);


            // start DB transaction to store
            DB::transaction(function() use ($user, $userInAdminTable, $id){

                if(request('image') == ""){
                    $name = request("image_hidden");
                }else{
                    $file = request('image');
                    $name = time() . '.' .$file->getClientOriginalExtension();
                    $path = public_path('back/images/users');
                    $file->move($path , $name);

                    if(request("image_hidden") != "df_image.png"){
                        File::delete(public_path('back/images/users/'.$userInAdminTable['image']));
                    }
                }

                $user->update([
                    'name' => request('name'),
                    'email' => request('email'),
                    'password' => request('password') == null ? $user['password'] : Hash::make(request('password')),
                    'user_role' => 22,
                    'user_status' => request('user_status'),
                    'active' => request('active'),
                    'updated_at' => Carbon::now(),
                ]);

                $userInAdminTable->update([
                    'gender' => request('gender'),
                    'phone' => request('phone'),
                    'birth_date' => request('birth_date'),
                    'nat_id' => request('nat_id'),
                    'address' => request('address'),
                    'notes' => request('notes'),
                    'image' => $name
                ]);




                // check if change auth()->user() active column
                // if(auth()->id() == $id){
                //     if(request('active') != $user['active']){
                //         auth()->user()->tokens()->delete();
                //         Auth::logout();
                //         return redirect('/login');
                //     }
                // }

            });
            // end DB transaction to store
        }
    }


    ///////////////////////////////////////////////  datatable  ////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function datatable()
    {
        $all = User::where('user_status', 1)
                    ->leftJoin('admins', 'admins.user_id', 'users.id')
                    ->select(
                        'users.id', 'users.name', 'users.email', 'users.user_status', 'users.user_role', 'users.active',
                        'admins.gender', 'admins.phone', 'admins.birth_date', 'admins.image', 'admins.address', 'admins.notes'
                    )
                    ->orWhere('users.user_status', 2)
                    ->get();
        return DataTables::of($all)
            ->addColumn('image', function($res){
                return '
                    <a class="spotlight" title="'.$res['name'].'" href="'.url('back/images/users/'.$res['image']).'">
                        <img src="'.url('back/images/users/'.$res['image']).'" alt="'.$res['text'].'" style="width: 25px;height: 25px;border-radius: 5px;margin: 0px auto;display: block;">
                    </a>
                ';
            })
            ->addColumn('status', function($res){
                if($res->active == 1){
                    return '<span class="label text-success" style="position: relative;"><div class="dot-label bg-success ml-1" style="position: absolute;right: -17px;top: 7px;"></div>نشط</span>';
                }else{
                    return '<span class="label text-danger" style="position: relative;"><div class="dot-label bg-danger ml-1" style="position: absolute;right: -15px;top: 7px;"></div>معطل</span>';
                }
            })
            ->addColumn('user_status', function($res){
                if($res->user_status == 1){
                    return '<span class="badge badge-success" style="width: 40px;">مدير</span>';
                }else if($res->user_status == 2){
                    return '<span class="badge badge-primary" style="width: 40px;">موظف</span>';
                }else if($res->user_status == 4){
                    return '<span class="badge badge-danger" style="width: 40px;">مدرس</span>';
                }else{
                    return '<span class="badge badge-warning" style="width: 40px;">أخري</span>';
                }
            })
            ->addColumn('gender', function($res){
                if($res->gender == 1){
                    return '<span class="badge badge-success" style="width: 40px;">ذكر</span>';
                }
                else{
                    return '<span class="badge badge-danger" style="width: 40px;">أنثي</span>';
                }
            })
            ->addColumn('action', function($res){
                // if (auth()->user()->role_relation->users_update == 1 ){
                // }
                return '
                            <button class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="'.$res->id.'">
                                <i class="fas fa-marker"></i>
                            </button>
                        ';
                // <button class="btn btn-sm btn-outline-danger delete" data-placement="top" data-toggle="tooltip" title="حذف" res_id="'.$res->id.'">
                //     <i class="fa fa-trash"></i>
                // </button>

            })
            ->rawColumns(['image', 'status', 'user_status', 'gender', 'action'])
            ->toJson();
    }



    public function changeAcademucYear($id){
        $find = DB::table('academic_years')->where('id', $id)->first();

        if($find || $id == 0){
            DB::table('users')->where('id', auth()->user()->id)->update([
                'selected_academic_year' => $id
            ]);
        }



        //$user = auth()->user()->id;

    }

}
