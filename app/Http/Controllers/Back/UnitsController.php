<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Units;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UnitsController extends Controller
{
    public function index()
    {                               
        $pageNameAr = 'الوحدات';
        $pageNameEn = 'units';
        return view('back.units.index' , compact('pageNameAr' , 'pageNameEn'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'name' => 'required|string|unique:units,name',
            ],[
                'name.required' => 'إسم الوحدة مطلوب',
                'name.string' => 'حقل إسم الوحدة يجب ان يكون من نوع نص',
                'name.unique' => 'إسم الوحدة مستخدم من قبل',                
            ]);

            Units::create($request->all());
        }
    }

    public function edit($id)
    {
        if(request()->ajax()){
            $find = Units::where('id', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $find = Units::where('id', $id)->first();

            $this->validate($request , [
                'name' => 'required|string|unique:units,name,'.$id,
            ],[
                'name.required' => 'إسم الوحدة مطلوب',
                'name.string' => 'حقل إسم الوحدة يجب ان يكون من نوع نص',
                'name.unique' => 'إسم الوحدة مستخدم من قبل',                
            ]);

            $find->update($request->all());
        }   
    }

     
    public function destroy($id)
    {
        
    }


    public function datatable()
    {
        $all = Units::orderBy('id', 'DESC')->get();

        return DataTables::of($all)
            ->addColumn('name', function($res){
                return '<strong>'.$res->name.'</strong>';
            })
            ->addColumn('action', function($res){
                return '
                    <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="'.$res->id.'">
                        <i class="fas fa-marker"></i>
                    </button>

                    <button class="btn btn-sm btn-outline-danger delete" data-placement="top" data-toggle="tooltip" title="حذف" res_id="'.$res->id.'">
                        <i class="fa fa-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['name', 'action'])
            ->toJson();
    }
}