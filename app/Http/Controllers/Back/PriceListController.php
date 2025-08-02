<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class PriceListController extends Controller
{
    public function index()
    {                
        $pageNameAr = 'جدول الأسعار';
        $pageNameEn = 'price_list';
        
        return view('back.price_list.index' , compact('pageNameAr' , 'pageNameEn'));
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'RoomName' => 'required|string|max:50|unique:tbl_rooms,RoomName',
                'RoomUser' => 'required|string',
                'RoomPass' => 'required',
                'status' => 'required|integer',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'RoomName' => 'اسم الغرفة الدراسية',
                'RoomUser' => 'اسم المستخدم',
                'RoomPass' => 'كلمة السر',
                'status' => 'الحالة',
            ]);

            $data = request()->except('_token');
            $data['created_at'] = Carbon::now();
            $data['academic_year'] = GetAcademicYaer();

            DB::table('tbl_prices')->insert($data);
        }
    }

    public function edit($id)
    {
        if(request()->ajax()){
            $find = Rooms::where('RoomID', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'RoomName' => 'required|string|max:50|unique:tbl_rooms,RoomName,'.$id.',RoomID',
                'RoomUser' => 'required|string',
                'RoomPass' => 'required',
                'status' => 'required|integer',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'RoomName' => 'اسم الغرفة الدراسية',
                'RoomUser' => 'اسم المستخدم',
                'RoomPass' => 'كلمة السر',
                'status' => 'الحالة',
            ]);

            $data = request()->except('_token');
            $data['updated_at'] = Carbon::now();

            Rooms::where('RoomID', $id)->update($data);
        }
    }

    public function datatable()
    {
        $all = DB::table('tbl_prices')
                ->leftJoin('tbl_years_mat', 'tbl_years_mat.ID', 'tbl_prices.YearID')
                ->leftJoin('academic_years', 'academic_years.id', 'tbl_parents.academic_year')
                ->select(
                    'tbl_prices.*', 
                    'tbl_years_mat.TheFullName as matName', 
                    'academic_years.name as academicYearName'
                    )
                ->get();

                dd("s");

        return DataTables::of($all)
            ->addColumn('YearID', function($res){
                return $res->matName;
            })      
            ->addColumn('action', function($res){
                return '
                    <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="'.$res->ID.'">
                        <i class="fas fa-marker"></i>
                    </button>
                ';
            })
            ->rawColumns(['YearID', 'action'])
            ->toJson();
    }
}
