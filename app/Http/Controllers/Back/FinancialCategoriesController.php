<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Rooms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class FinancialCategoriesController extends Controller
{
    public function index()
    {                
        $pageNameAr = 'تصنيفات العمليات المالية';
        $pageNameEn = 'financial_categories';
        
        return view('back.financial_categories.index' , compact('pageNameAr' , 'pageNameEn'));
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'IncomeCatName' => 'required|string|max:50|unique:tbl_income_cat,IncomeCatName',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'IncomeCatName' => 'التصنيف',
            ]);

            $data = request()->except('_token');

            DB::table('tbl_income_cat')->insert($data);
        }
    }

    public function edit($id)
    {
        if(request()->ajax()){
            $find = DB::table('tbl_income_cat')->where('IncomeCatID', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'IncomeCatName' => 'required|string|max:50|unique:tbl_income_cat,IncomeCatName,'.$id.',IncomeCatID',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'IncomeCatName' => 'التصنيف',
            ]);

            $data = request()->except('_token');

            DB::table('tbl_income_cat')->where('IncomeCatID', $id)->update($data);
        }
    }

    public function datatable()
    {
        $all = DB::table('tbl_income_cat')->get();

        return DataTables::of($all)
            ->addColumn('action', function($res){
                return '
                    <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="'.$res->IncomeCatID.'">
                        <i class="fas fa-marker"></i>
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
