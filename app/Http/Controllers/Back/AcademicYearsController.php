<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\AcademicYears;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class AcademicYearsController extends Controller
{
    public function index()
    {                               
        $pageNameAr = 'سنوات الأكاديمية';
        $pageNameEn = 'academic_years';
        return view('back.academic_years.index' , compact('pageNameAr' , 'pageNameEn'));
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $activeYear = AcademicYears::where('status', 1)->first();

            if($activeYear){
                return response()->json(['foundedActiveYear' => 'تحذير: هناك سنة دراسية لم تقفل بعد']);
            }

            $this->validate($request , [
                'name' => 'required|string|unique:academic_years,name',
                'start' => 'required|date',
                'end' => 'required|date',
                'notes' => 'nullable|string|max:255',
            ],[
                'required' => 'حقل :attribute إلزامي.',
                'string' => 'حقل :attribute يجب ان يكون من نوع نص.',
                'unique' => 'حقل :attribute مستخدم من قبل.',
                'max' => 'حقل :attribute أقصي قيمة له هي 255 حرف.',
                'date' => 'حقل :attribute يجب ان يكون من نوع تاريخ.',

            ],[
                'name' => 'إسم السنة ',                
                'start' => 'تاريخ بداية السنة ',                
                'end' => 'تاريخ نهاية السنة ',                
                'notes' => 'الملاحظات',                
            ]);

            AcademicYears::create($request->all());
        }
    }

    public function edit($id)
    {
        if(request()->ajax()){
            $find = AcademicYears::where('id', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $find = AcademicYears::where('id', $id)->first();
            
            $this->validate($request , [
                'name' => 'required|string|unique:academic_years,name,'.$id,
                'start' => 'required|date',
                'end' => 'required|date',
                'notes' => 'nullable|string|max:255',
            ],[
                'required' => 'حقل :attribute إلزامي.',
                'string' => 'حقل :attribute يجب ان يكون من نوع نص.',
                'unique' => 'حقل :attribute مستخدم من قبل.',
                'max' => 'حقل :attribute أقصي قيمة له هي 255 حرف.',
                'date' => 'حقل :attribute يجب ان يكون من نوع تاريخ.',

            ],[
                'name' => 'إسم السنة ',                
                'start' => 'تاريخ بداية السنة ',                
                'end' => 'تاريخ نهاية السنة ',                
                'notes' => 'الملاحظات',                
            ]);

            $find->update($request->all());
        }   
    }


    public function datatable()
    {
        $all = AcademicYears::orderBy('id', 'DESC')->get();

        return DataTables::of($all)
            ->addColumn('name', function($res){
                return '<strong>'.$res->name.'</strong>';
            })
            ->addColumn('start', function($res){
                return '<strong>'.Carbon::parse($res->start)->format('Y-m-d').'</strong>';
            })
            ->addColumn('end', function($res){
                return '<strong>'.Carbon::parse($res->end)->format('Y-m-d').'</strong>';
            })
            ->addColumn('notes', function($res){
                return '<strong data-bs-toggle="tooltip" data-bs-placement="top" title="'.$res->notes.'">'.Str::words($res->notes, 10, ' ....').'</strong>';
            })
            ->addColumn('status', function($res){
                if($res->status == 1){
                    return '<span class="label text-success" style="position: relative;"><div class="dot-label bg-success ml-1" style="position: absolute;right: -17px;top: 7px;"></div>نشط</span>';
                }
                else{
                    return '<span class="label text-danger" style="position: relative;"><div class="dot-label bg-danger ml-1" style="position: absolute;right: -15px;top: 7px;"></div>معطل</span>';
                }
            })
            ->addColumn('action', function($res){
                if($res->status == 1){
                    return '
                        <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="'.$res->id.'">
                            <i class="fas fa-marker"></i>
                        </button>
                    ';
                }
            })
            ->rawColumns(['name', 'start', 'end', 'notes', 'status', 'action'])
            ->toJson();
    }
}