<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeacherSalaryController extends Controller
{
    public function index()
    {                              
        $pageNameAr = 'كشف مدفوعات المدرسين 💰';
        $pageNameEn = 'teacher-salaries';

        $wallets = DB::table('tblwallets')->get();
        $teachers = DB::table('tbl_teachers')->select('ID', 'TheName')->orderBy('TheName', 'ASC')->get();
        $academic_years = DB::table('academic_years')->orderBy('id', 'asc')->get();

        return view('back.teacher_salaries.index' , compact('pageNameAr' , 'pageNameEn', 'wallets', 'teachers', 'academic_years'));
    }

    // start store group
    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'TheDate' => 'required|string',
                'TeacherID' => 'required|integer|exists:tbl_teachers,ID',
                'TheAmount' => 'required|numeric|not_in:0',
                'TheNotes' => 'nullable|string',
                'TheType' => 'required|string',
                'ThePayType' => 'required|string',
                'WalletID' => 'required|integer|exists:tblwallets,WalletID',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'date' => ':attribute يجب ان يكون تاريخ.',
                'integer' => ':attribute يجب ان يكون رقم.',
                'numeric' => ':attribute يجب ان يكون رقم.',
                'not_in' => ':attribute يجب ألا يساوي :values.',
                'exists' => ':attribute غير موجود في قاعدة البيانات.',
            ],[
                'TheDate' => 'تاريخ الدفع',
                'TeacherID' => 'المدرس',
                'TheAmount' => 'المبلغ',
                'TheNotes' => 'ملاحظات',
                'TheType' => 'نوع العملية',
                'ThePayType' => 'طريقة الدفع',
                'WalletID' => 'المحفظة',
            ]);                    

            $data = request()->except(['_token']);
            $data['academic_year'] = GetAcademicYaer();                
            $data['TheDate'] = request('TheDate') ?? now();                
            
            DB::table('tbl_teachers_payments')->insert($data);
        }
    }
    // end store group


    public function edit($id){
        if(request()->ajax()){
            $find = DB::table('tbl_teachers_payments')->where('ID', $id)->first();
            $paymentMonth = Carbon::parse($find->TheDate)->month;
            $currentMonth = Carbon::now()->month;

            if ($paymentMonth != $currentMonth && $paymentMonth != ($currentMonth - 1)) {
                return response()->json([
                    'noEdit' => "⚠️ عذرًا، لا يمكن تعديل المدفوعات المسجلة بتاريخ:<br><strong>{$find->TheDate}</strong>"
                ]);
            } else {
                return response()->json($find);
            }
        }
        return view('back.welcome');
    }

    public function update(Request $request, $id)
    {
        if (request()->ajax()){
            $this->validate($request , [
                'TheDate' => 'required|string',
                'TeacherID' => 'required|integer|exists:tbl_teachers,ID',
                'TheAmount' => 'required|numeric|not_in:0',
                'TheNotes' => 'nullable|string',
                'TheType' => 'required|string',
                'ThePayType' => 'required|string',
                'WalletID' => 'required|integer|exists:tblwallets,WalletID',
            ],[
                'required' => ':attribute مطلوب.',
                'string' => ':attribute غير صحيح.',
                'date' => ':attribute يجب ان يكون تاريخ.',
                'integer' => ':attribute يجب ان يكون رقم.',
                'numeric' => ':attribute يجب ان يكون رقم.',
                'not_in' => ':attribute يجب ألا يساوي :values.',
                'exists' => ':attribute غير موجود في قاعدة البيانات.',
            ],[
                'TheDate' => 'تاريخ الدفع',
                'TeacherID' => 'المدرس',
                'TheAmount' => 'المبلغ',
                'TheNotes' => 'ملاحظات',
                'TheType' => 'نوع العملية',
                'ThePayType' => 'طريقة الدفع',
                'WalletID' => 'المحفظة',
            ]);                    

            $data = request()->except(['_token']);
            $data['TheDate'] = request('TheDate') ?? now();                
            
            DB::table('tbl_teachers_payments')->where('ID', $id)->update($data);
        }
    }


    // start destroy group
    public function destroy($id){
        $find = DB::table('tbl_teachers_payments')->where('ID', $id)->first();
        $paymentMonth = Carbon::parse($find->TheDate)->month;
        $currentMonth = Carbon::now()->month;

        if ($paymentMonth != $currentMonth && $paymentMonth != ($currentMonth - 1)) {
            return response()->json([
                'noDelete' => "🗑️⚠️ عذرًا، لا يمكن حذف المدفوعات المسجلة بتاريخ:<br><strong>{$find->TheDate}</strong>"
            ]);

        } else {
            DB::table('tbl_teachers_payments')->where('ID', $id)->delete();
        }
    }
    // end destroy group
    

    // start datatable group
    public function datatable(Request $request)
    {
        $academic_year = $request->academic_year;
        $from = $request->from ?? null;
        $to = $request->to ?? null;

        $query = DB::table('tbl_teachers_payments')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_teachers_payments.TeacherID')
                    ->leftJoin('tblwallets', 'tblwallets.WalletID', 'tbl_teachers_payments.WalletID')
                    ->leftJoin('academic_years', 'academic_years.id', 'tbl_teachers_payments.academic_year')
                    ->select(
                        'tbl_teachers_payments.*',
                        'tbl_teachers.TheName', 
                        'tblwallets.WalletName', 
                        'academic_years.name as academicYearName',
                    );


        if ($from && $to) {
            $query->whereBetween('tbl_teachers_payments.TheDate', [$from, $to]);
        } elseif ($from) {
            $query->where('tbl_teachers_payments.TheDate', '>=', $from);
        } elseif ($to) {
            $query->where('tbl_teachers_payments.TheDate', '<=', $to);
        }
        
        if($academic_year){
            $query->where('tbl_teachers_payments.academic_year', $academic_year);
        }
        
        $all = $query->get();
                    
        return DataTables::of($all)
            ->addColumn('TheName', function($res) {
                return '#' . e($res->TeacherID) . '</span>' .
                        ' - <span class="text-primary" style="font-weight:bold;"> ' . e($res->TheName) . '</span>';
            })
            ->addColumn('ThePayType', function($res) {
                return '<span style="font-weight:bold;"> ' . e($res->ThePayType) . '</span>';
            })
            ->addColumn('TheDate', function($res) {
                $paymentMonth = Carbon::parse($res->TheDate)->month;
                $currentMonth = Carbon::now()->month;


                if ($paymentMonth != $currentMonth && $paymentMonth != ($currentMonth - 1)) {                
                    return '<span class="badge badge-danger rounded" style="font-weight:bold;font-size: 12px !important;"> ' . e( $res->TheDate ) . '</span>';

                } else {
                    return '<span class="" style="font-weight:bold;font-size: 12px !important;"> ' . e( $res->TheDate ) . '</span>';
                }
            })
            ->addColumn('TheAmount', function($res) {
                return '<span class="badge badge-purple rounded" style="font-weight:bold;font-size: 14px !important;"> ' . e( display_number($res->TheAmount) ) . '</span>';
            })
            ->addColumn('TheNotes', function($res) {
                return '<span class="" data-bs-toggle="popover" data-bs-placement="bottom" title="' . e($res->TheNotes) . '">
                            ' . e(Str::limit($res->TheNotes, 40)) . '
                        </span>';
            })
            ->addColumn('action', function($res) {
                $paymentMonth = Carbon::parse($res->TheDate)->month;
                $currentMonth = Carbon::now()->month;


                if ($paymentMonth != $currentMonth && $paymentMonth != ($currentMonth - 1)) {
                    return '';
                } else {
                    return '
                            <button type="button" class="btn btn-sm btn-outline-danger delete" data-placement="top" data-toggle="tooltip" title="' . __('حذف') . '" res_id="' . e($res->ID) . '" date="' . e($res->TheDate) . '">
                                <i class="fa fa-trash-alt"></i>
                            </button>
    
                            <button class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-toggle="modal" href="#exampleModalCenter" data-placement="top" data-toggle="tooltip" title="' . __('تعديل') . '" res_id="' . e($res->ID) . '">
                                <i class="fas fa-marker"></i>
                            </button>';
                }
            })
            ->rawColumns(['TheNotes', 'TheDate', 'TheName', 'ThePayType', 'TheAmount', 'status', 'action'])
            ->toJson();
    }
    // end datatable group

}