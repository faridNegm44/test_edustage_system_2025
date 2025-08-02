<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Times;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TimesController extends Controller
{
    public function index()
    {                               
        $pageNameAr = 'أوقات الجدول الدراسي';
        $pageNameEn = 'times';
        $lastOrder = Times::latest()->first();
        
        // dd($lastOrder == null ? 1 : ($lastOrder['order']+1));
        return view('back.times.index' , compact('pageNameAr' , 'pageNameEn', 'lastOrder'));
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            // $time = $request->input('time');
            // $amPm = $request->input('am_pm');
            
            // if(Times::where('time', $time)->exists() && Times::where('am_pm', $amPm)->exists()){
            //     return response()->json(['status' => 'error', 'message' => 'هذا الوقت
            //     موجود بالفعل']);
            // }



            $this->validate($request , [
                'time' => 'required',
                'order' => 'required|integer',
            ],[
                'required' => ':attribute مطلوب.',
                'integer' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
            ],[
                'time' => 'الوقت',
                'order' => 'ترتيب الوقت',
            ]);

            $time = Times::create($request->all());
            return response()->json(['responseLastId' => ($time->order) + 1]);
        }
    }

    public function edit($id)
    {
        if(request()->ajax()){
            $find = Times::where('id', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $find = Times::where('id', $id)->first();
            
            $this->validate($request , [
                'time' => 'required',
                'order' => 'required|integer',
            ],[
                'required' => ':attribute مطلوب.',
                'integer' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
            ],[
                'time' => 'الوقت',
                'order' => 'ترتيب الوقت',
            ]);

            
            $find->update($request->all());
        }
    }

     
    public function destroy($id)
    {
        if(request()->ajax()){
            $find = Times::where('id', $id)->first();
            $find->delete();
        }
        return view('back.welcome');
    }


    public function datatable()
    {
        $all = Times::orderBy('am_pm', 'asc')->orderBy('order', 'asc')->get();

        return DataTables::of($all)
            ->addColumn('time', function($res){
                return $res->time. ' '. $res->am_pm;
            })      
            ->addColumn('order', function($res){
                return $res->order;
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
            ->rawColumns(['time', 'am_pm', 'order', 'action'])
            ->toJson();
    }
}
