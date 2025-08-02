<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\CrmColumnsNames;
use App\Models\Back\CrmCategories;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CrmColumnsNamesController extends Controller
{
    public function index()
    {                               
        $pageNameAr = 'أسماء أقسام CRM';
        $pageNameEn = 'crm_columns_names';
        $crm_categories = CrmCategories::all();
        return view('back.crm_columns_names.index' , compact('pageNameAr' , 'pageNameEn', 'crm_categories'));
    }

    public function lastOrderNumber($id)
    {                
        $lastOrderNumber = CrmColumnsNames::where('category', $id)->orderBy('order', 'desc')->first();
        if(!$lastOrderNumber){
            $lastOrderNumber = 1;
        }else{
            $lastOrderNumber = ($lastOrderNumber->order+1);
        }
        return response()->json($lastOrderNumber);
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'category' => 'required',
                'name_ar' => 'required|unique:crm_columns_names,name_ar',
            ],[
                'required' => ':attribute مطلوب.',
                'integer' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
            ],[
                'name_ar' => 'الإسم',
                'category' => 'التصنيف',
            ]);

            CrmColumnsNames::create($request->all());
        }
    }

    public function edit($id)
    {
        if(request()->ajax()){
            $find = CrmColumnsNames::where('id', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $find = CrmColumnsNames::where('id', $id)->first();
        // dd($request->all());
            $this->validate($request , [
                'category' => 'required',
                'name_ar' => 'required|unique:crm_columns_names,name_ar,'.$id,
            ],[
                'required' => ':attribute مطلوب.',
                'integer' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدممن قبل.',
            ],[
                'name_ar' => 'الإسم بالعربية',
                'category' => 'التصنيف',
            ]);

            
            $find->update($request->all());
        }
    }

     
    public function destroy($id)
    {
        if(request()->ajax()){
            $find = CrmColumnsNames::where('id', $id)->first();
            $find->delete();
        }
        return view('back.welcome');
    }


    public function datatable()
    {
        $all = CrmColumnsNames::orderBy('category', 'asc')
                                ->orderBy('order', 'asc')
                                ->leftJoin('crm_categories', 'crm_categories.id', 'crm_columns_names.category')
                                ->select('crm_columns_names.*', 'crm_categories.name as categ_name')
                                ->get();

        return DataTables::of($all)
            ->addColumn('category', function($res){
                return $res->categ_name;
            })      
            ->addColumn('status', function($res){
                if($res->status == 1){
                    return '<span class="badge badge-success" style="width: 40px;">نشط</span>';
                }
                else{
                    return '<span class="badge badge-danger" style="width: 40px;">معطل</span>';
                }
            })
            ->addColumn('action', function($res){
                return '
                    <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="'.$res->id.'">
                        <i class="fas fa-marker"></i>
                    </button>

                    <button type="button" class="btn btn-sm btn-outline-danger delete DBtn" data-placement="top" data-toggle="tooltip" title="حذف" res_id="'.$res->id.'">
                        <i class="fa fa-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['category', 'status', 'action'])
            ->toJson();
    }
}