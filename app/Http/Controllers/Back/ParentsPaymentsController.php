<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ParentsPaymentsController extends Controller
{
    public function index()
    {          
        
        $pageNameAr = 'متحصّلات من أولياء الأمور 💰📚';
        $pageNameEn = 'parent-payments';

        $wallets = DB::table('tblwallets')->get();
        $parents = DB::table('tbl_parents')->select('ID', 'TheName0')->orderBy('TheName0', 'ASC')->get();
        $academic_years = DB::table('academic_years')->orderBy('id', 'asc')->get();

        return view('back.parent_payments.index' , compact('pageNameAr' , 'pageNameEn', 'wallets', 'parents', 'academic_years'));
    }

    // start store group
    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'GroupName' => 'required|string|max:100',
                'TheName0' => 'required|date',
                'CloseDate' => 'nullable|date',
                'ClassType' => 'required|string',
                'ParentID' => 'required|integer|exists:tbl_parents,ID',
                'TeacherID' => 'required|integer|exists:tbl_teachers,ID',
                'TheLangID' => 'required|integer|exists:tbl_langs,LangID',
                'TheTestType' => 'required|string',
                'ClassNo1' => 'required|integer|min:0',
                'ThePrice' => 'required|numeric|min:0',
                'TheNotes' => 'nullable|string',
                'GroupTeacherPayType' => 'required|in:نسبة,قيمة ثابتة',
                'GroupStaticValue' => 'nullable|numeric|min:0',
                'GroupExtraValue' => 'nullable|numeric|min:0',
                'GroupMiniStudents' => 'nullable|numeric|min:0',                
                
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'date' => ':attribute يجب ان يكون تاريخ.',
                'unique' => ':attribute مستخدم من قبل.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'min' => ':attribute أقل من القيمة المطلوبة.',
                'integer' => ':attribute يجب ان يكون رقم.',
                'numeric' => ':attribute يجب ان يكون رقم.',
                'exists' => ':attribute غير موجود في قاعدة البيانات.',
            ],[
                'GroupName' => 'إسم المجموعة',
                'OpenDate' => 'تاريخ الإفتتاح',
                'CloseDate' => 'تاريخ الإغلاق',
                'ClassType' => 'الباقة',
                'ParentID' => 'المادة الدراسية',
                'TeacherID' => 'المدرس',
                'TheLangID' => 'نظام التعليم',
                'TheTestType' => 'نظام الإختبارات',
                'ClassNo1' => 'عدد حصص متوقع',
                'ThePrice' => 'السعر',
                'TheNotes' => 'ملاحظات',
                'GroupTeacherPayType' => 'النظام',
                'GroupStaticValue' => 'قيمة ثابتة',
                'GroupExtraValue' => 'قيمة الإضافي',
                'GroupMiniStudents' => 'الحد الأدني للقيمة الثابتة',
            ]);                    

            $data = request()->except(['_token', 'GroupPercentageValue']);
            $data['TheStatus'] = 'مفتوحة';
            $data['academic_year'] = GetAcademicYaer();                
            $data['OpenDate'] = request('OpenDate') ?? now();                
            $data['CloseDate'] = request('CloseDate') ?? null;                
            $data['GroupTeacherPayType'] = request('GroupTeacherPayType') ;
            
            if(request('GroupTeacherPayType') == 'قيمة ثابتة'){
                $data['GroupStaticValue'] = request('GroupStaticValue');
            }else{
                $data['GroupStaticValue'] = 0;
            }
            
            $data['GroupExtraValue'] = request('GroupExtraValue') ? request('GroupExtraValue') : 0 ;
            $data['GroupMiniStudents'] = request('GroupMiniStudents') ? request('GroupMiniStudents') : 0 ;

            DB::table('tbl_groups')->insert($data);
        }
    }
    // end store group


    public function edit($id){
        if(request()->ajax()){
            $find = DB::table('tbl_groups')->where('ID', $id)->first();
            return response()->json($find);
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'GroupName' => 'required|string|max:100',
                'ClassNo1' => 'required|integer|min:0',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'unique' => ':attribute مستخدم من قبل.',
                'max' => ':attribute أكبر من القيمة المطلوبة.',
                'integer' => ':attribute غير صحيح.',
            ],[
                'GroupName' => 'إسم المجموعة',
                'ClassNo1' => 'عدد حصص متوقع',
            ]);

            DB::table('tbl_groups')->where('ID', $id)->update([
                'GroupName' => request('GroupName'),
                'ClassNo1' => request('ClassNo1'),
            ]);
        }
    }


    // start destroy group
    public function destroy($id){
        $students = DB::table('tbl_groups_students')->where('GroupID', $id)->count();
        if($students > 0){
            return response()->json(['founded' => 'لا يمكن حذف هذا المجموعة لوجود طلاب في هذة المجموعة']);
        }else{
            DB::table('tbl_groups')->where('ID', $id)->delete();
        }
    }
    // end destroy group
    

    // start datatable group
    public function datatable(Request $request)
    {
        $academic_year = $request->academic_year;
        $from = $request->from ?? null;
        $to = $request->to ?? null;

        $query = DB::table('tbl_parents_payments')
                    ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_parents_payments.ParentID')
                    ->leftJoin('tblwallets', 'tblwallets.WalletID', 'tbl_parents_payments.WalletID')
                    ->leftJoin('academic_years', 'academic_years.id', 'tbl_parents_payments.academic_year')
                    ->select(
                        'tbl_parents_payments.*',
                        'tbl_parents.TheName0', 
                        'tblwallets.WalletName', 
                        'academic_years.name as academicYearName',
                    );


        if ($from && $to) {
            $query->whereBetween('tbl_parents_payments.TheDate', [$from, $to]);
        } elseif ($from) {
            $query->where('tbl_parents_payments.TheDate', '>=', $from);
        } elseif ($to) {
            $query->where('tbl_parents_payments.TheDate', '<=', $to);
        }
        
        if($academic_year){
            $query->where('tbl_parents_payments.academic_year', $academic_year);
        }
        
        $all = $query->get();
                    
        return DataTables::of($all)
            ->addColumn('ID', function($res) {
                return '<span class="badge badge-warning text-dark" style="font-size:110% !important;"> #' . e($res->ID) . '</span>';
            })
            ->addColumn('TheName0', function($res) {
                return '<span class="text-primary" style="font-weight:bold;"> ' . e($res->TheName0) . '</span>';
            })
            ->addColumn('TheDate', function($res) {
                $TheDate = Carbon::parse($res->TheDate);
                $currentDate = Carbon::today();

                if ( $currentDate->isSameMonth($TheDate) || $currentDate->copy()->subMonth()->isSameMonth($TheDate) ) {             
                    return '<span class="" style="font-weight:bold;font-size: 12px !important;"> ' . e( $res->TheDate ) . '</span>';
                    
                } else {
                    return '<span class="badge badge-danger rounded" style="font-weight:bold;font-size: 12px !important;"> ' . e( $res->TheDate ) . '</span>';
                }
            })
            ->addColumn('ThePayType', function($res) {
                return '<span style="font-weight:bold;"> ' . e($res->ThePayType) . '</span>';
            })
            ->addColumn('TheAmount', function($res) {
                $res->TheAmount = $res->TheAmount ?? 0;
                if ($res->TheAmount < 0) {
                    return '<span class="text-danger rounded" style="font-weight:bold;font-size: 110% !important;"> ' . e($res->TheAmount) . '</span>';
                }
                return '<span style="font-weight:bold;font-size: 110% !important;"> ' . e($res->TheAmount) . '</span>';
            })
            ->addColumn('amount_by_currency', function($res) {
                $res->amount_by_currency = $res->amount_by_currency ?? 0;
                if ($res->amount_by_currency < 0) {
                    return '<span class="badge badge-danger rounded" style="font-weight:bold;font-size: 110% !important;width: 80%;"> ' . e($res->amount_by_currency) . '</span>';
                }
                return '<span class="badge badge-primary rounded" style="font-weight:bold;font-size: 14px !important;width: 80%;"> ' . e($res->amount_by_currency) . '</span>';
            })
            ->addColumn('TheNotes', function($res) {
                return '<span class="" data-bs-toggle="popover" data-bs-placement="bottom" title="' . e($res->TheNotes) . '">
                            <i class="fas fa-sticky-note"></i> ' . e(Str::limit($res->TheNotes, 20)) . '
                        </span>';
            })
            ->addColumn('admin_notes', function($res) {
                return '<span class="" data-bs-toggle="popover" data-bs-placement="bottom" title="' . e($res->admin_notes) . '">
                            <i class="fas fa-user-shield"></i> ' . e(Str::limit($res->admin_notes, 40)) . '
                        </span>';
            })
            ->addColumn('status', function($res) {
                $statusClass = $res->status == 'مؤكد' ? 'badge-success' : 'badge-danger';
                $statusIcon = $res->status == 'مؤكد' ? 'fa-check-circle' : 'fa-times-circle';
                $statusText = $res->status == 'مؤكد' ? __('مؤكد') : __('غير مؤكد');

                return '<span class="badge ' . $statusClass . '" style="font-size:12px;"><i class="fas ' . $statusIcon . '"></i> ' . $statusText . '</span>';
            })
            ->addColumn('action', function($res) {
                $TheDate = Carbon::parse($res->TheDate);
                $currentDate = Carbon::today();

                if ( $currentDate->isSameMonth($TheDate) || $currentDate->copy()->subMonth()->isSameMonth($TheDate) ) {
                    $closeButton = $res->status != 'مؤكد' ? '<button class="btn btn-sm btn-dark close_group" data-effect="effect-scale" data-toggle="modal" href="#closeGroupForm" data-placement="top" data-toggle="tooltip" title="' . __('إغلاق المجموعة نهائيا') . '" res_id="' . e($res->ID) . '">
                                <i class="fas fa-lock"></i>
                            </button>' : '';
    
                    return $closeButton . '
                            <button type="button" class="btn btn-sm btn-outline-danger delete" data-placement="top" data-toggle="tooltip" title="' . __('حذف') . '" res_id="' . e($res->ID) . '">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#editForm" data-placement="top" data-toggle="tooltip" title="' . __('تعديل') . '" res_id="' . e($res->ID) . '">
                                <i class="fas fa-marker"></i>
                            </button>';
                     
                } else {
                    return '';
                }
            })
            ->rawColumns(['ID', 'TheDate', 'TheNotes', 'TheName0', 'ThePayType', 'TheAmount', 'amount_by_currency', 'admin_notes', 'status', 'action'])
            ->toJson();
    }
    // end datatable group

}