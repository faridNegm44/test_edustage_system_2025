<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Rooms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class GroupSessionsController extends Controller
{
    public function index($id)
    {                
        $groupInfo = DB::table('tbl_groups')->where('ID', $id)->first();
        $pageNameAr = 'حصص المجموعة التعليمية 👨‍🏫';
        $pageNameEn = 'groups-sessions';

        if($groupInfo){
            return view('back.groups_sessions.index' , compact('pageNameAr' , 'pageNameEn', 'id', 'groupInfo'));
        }else{
            return redirect('/');
        }
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'TheDate' => 'required|date',
            ],[
                'required' => ':attribute مطلوب.',
                'date' => ':attribute غير صحيح.',
            ],[
                'TheDate' => 'تاريخ الحصة',
            ]);

            $maxId = DB::table('tbl_groups_classes')->where('GroupID', request('GroupID'))->max('ClassNumber');
            DB::table('tbl_groups_classes')->insert([
                'GroupID' =>  request('GroupID'),
                'TheDate' =>  request('TheDate'),
                'ClassNumber' =>  ($maxId + 1),
                'academic_year' =>  GetAcademicYaer(),
                'TheStatus' =>  'غير مؤكد',
            ]);
        }
    }

    public function edit($id)
    {
        if(request()->ajax()){
            $find = DB::table('tbl_groups_classes')->where('ID', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'TheDate' => 'required|date',
            ],[
                'required' => ':attribute مطلوب.',
                'date' => ':attribute غير صحيح.',
            ],[
                'TheDate' => 'تاريخ الحصة',
            ]);

            DB::table('tbl_groups_classes')->where('ID', $id)->update([
                'TheDate' =>  request('TheDate'),
            ]);
        }
    }

    public function destroy($id){
        $sessions = DB::table('tbl_groups_classes_att')->where('ClassID', $id)->count();
        
        if($sessions > 0){
            return response()->json(['founded' => 'لا يمكن حذف الحصة']);

        }else{
            DB::table('tbl_groups_classes')->where('ID', $id)->delete();
        }
    }

    public function datatable($id)
    {
        $all = DB::table('tbl_groups_classes')
                ->where('tbl_groups_classes.GroupID', $id)
                ->leftJoin('academic_years', 'academic_years.id', 'tbl_groups_classes.academic_year')
                ->select(
                    'tbl_groups_classes.*',
                    'academic_years.name as academicYearName'
                )
                ->get();

        return DataTables::of($all)
            ->addColumn('TheStatus', function($res){
                if($res->TheStatus == 'مؤكد'){
                    return '<span class="label text-success" style="position: relative;"><div class="dot-label bg-success ml-1" style="position: absolute;right: -17px;top: 7px;"></div>مؤكد</span>';
                    
                }elseif($res->TheStatus == 'غير مؤكد'){
                    return '<span class="label text-danger" style="position: relative;"><div class="dot-label bg-danger ml-1" style="position: absolute;right: -15px;top: 7px;"></div>غير مؤكد</span>';

                }else{
                    return '<span class="label text-danger" style="position: relative;"><div class="dot-label bg-danger ml-1" style="position: absolute;right: -15px;top: 7px;"></div>غير مؤكد</span>';
                }
            }) 
            ->addColumn('action', function($res){
                $groupInfo = DB::table('tbl_groups')->where('ID', $res->GroupID)->first();

                if($groupInfo->TheStatus != 'مغلقة'){
                    return '
                        <a href="'.url('groups-sessions/attendance').'/'.$res->GroupID.'/'.$res->ID.'" class="btn btn-sm btn-outline-secondary text-center" data-effect="effect-scale" data-placement="top" data-toggle="tooltip" title="تفقد حضور وغياب الطلاب" res_id="'.$res->ID.'" group_id="'.$res->GroupID.'">
                            <i class="fas fa-user-check"></i>
                        </a>
    
                        <button type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="'.$res->ID.'">
                            <i class="fas fa-marker"></i>
                        </button>
                        
                        <button type="button" class="btn btn-sm btn-outline-danger delete" data-effect="effect-scale" data-placement="top" data-toggle="tooltip" title="حذف الحصة" res_id="'.$res->ID.'" TheDate="'.$res->TheDate.'">
                            <i class="fa fa-trash"></i>
                        </button>                    
                    ';
                }else{
                    return '
                        <a href="'.url('groups-sessions/attendance').'/'.$res->GroupID.'" class="btn btn-sm btn-outline-secondary text-center" data-effect="effect-scale" data-placement="top" data-toggle="tooltip" title="تفقد حضور وغياب الطلاب" res_id="'.$res->ID.'" group_id="'.$res->GroupID.'">
                            <i class="fas fa-user-check"></i>
                        </a>
                    ';
                }
            })
            ->rawColumns(['TheStatus', 'action'])
            ->toJson();
    }
}