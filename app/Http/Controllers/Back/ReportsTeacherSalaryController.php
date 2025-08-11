<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\ClientsAndSuppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportsTeacherSalaryController extends Controller
{
    public function index()
    {         
        //if((userPermissions()->clients_report_view)){
            $pageNameAr = '📑 تقرير كشف مدفوعات المدرسين 💰';        
            $teachers = DB::table('tbl_teachers')->select('ID', 'TheName')->orderBy('TheName', 'asc')->get();   
            
            return view('back.reports.teacher_salary.index' , compact('pageNameAr', 'teachers'));
	
        //}else{
        //    return redirect('/')->with(['notAuth' => 'عذرًا، ليس لديك صلاحية لتنفيذ طلبك']);
        //}  
                  
    }

    public function result(Request $request)
    {                   
        $pageNameAr = '📑 تقرير كشف مدفوعات المدرسين 💰'; 

        $teacher_id = request('teacher_id');
        $from = $request->from ? date('Y-m-d', strtotime($request->from)) : null;
        $to = $request->to ? date('Y-m-d', strtotime($request->to)) : null;

        $query = DB::table('tbl_teachers_payments')
                        ->leftJoin('financial_treasuries', 'financial_treasuries.id', 'tbl_teachers_payments.treasury_id')
                        ->join('clients_and_suppliers', 'clients_and_suppliers.id', 'tbl_teachers_payments.TeacherID')
                        ->leftJoin('financial_years', 'financial_years.id', 'tbl_teachers_payments.year_id')
                        ->leftJoin('users', 'users.id', 'tbl_teachers_payments.user_id')
                        ->select(
                            'tbl_teachers_payments.*', 
                            'financial_treasuries.name as treasury_name',
                            'clients_and_suppliers.code as clientCode', 'clients_and_suppliers.name as clientName', 'clients_and_suppliers.client_supplier_type',
                            'users.name as userName',
                            'financial_years.name as financialYearName',
                        )
                        ->whereIn('clients_and_suppliers.client_supplier_type', [3, 4])
                        ->orderBy('tbl_teachers_payments.id', 'asc');

        if ($from && $to) {
            $query->whereBetween('tbl_teachers_payments.TheDate', [$from, $to]);
        } elseif ($from) {
            $query->where('tbl_teachers_payments.TheDate', '>=', $from);
        } elseif ($to) {
            $query->where('tbl_teachers_payments.TheDate', '<=', $to);
        }
        
        if($teacher_id){
            $query->where('tbl_teachers_payments.TeacherID', $teacher_id);
        }
        
        if($treasury_type){
            $query->where('tbl_teachers_payments.treasury_type', $treasury_type);
        }

        $results = $query->paginate(50);       

        if($results->total() == 0){
            return redirect()->back()->with('notFound', 'لايوجد مدفوعات تمت بناءا علي بحثك');
        }else{
            return view('back.reports.teacher_salary.result' , compact('pageNameAr', 'results', 'treasury_type', 'teacher_id', 'from', 'to'));
        }
    }
    
    public function result_pdf(Request $request)
    {                   
        $pageNameAr = 'تفاصيل مدفوعات السيد المدرس'; 

        $teacher_id = request('teacher_id');
        $from = $request->from ? date('Y-m-d', strtotime($request->from)) : null;
        $to = $request->to ? date('Y-m-d', strtotime($request->to)) : null;
                        
        $query = DB::table('tbl_teachers_payments')
                    ->leftJoin('tbl_teachers', 'tbl_teachers.ID', 'tbl_teachers_payments.TeacherID')
                    ->leftJoin('tblwallets', 'tblwallets.WalletID', 'tbl_teachers_payments.WalletID')
                    ->leftJoin('academic_years', 'academic_years.id', 'tbl_teachers_payments.academic_year')
                    ->select(
                        'tbl_teachers_payments.*',
                        'tbl_teachers.TheName', 
                        'tblwallets.WalletName', 
                        'academic_years.name as academicYearName',
                    )
                    ->orderBy('tbl_teachers_payments.TheDate', 'asc');

        if ($from && $to) {
            $query->whereBetween('tbl_teachers_payments.TheDate', [$from, $to]);
        } elseif ($from) {
            $query->where('tbl_teachers_payments.TheDate', '>=', $from);
        } elseif ($to) {
            $query->where('tbl_teachers_payments.TheDate', '<=', $to);
        }
        
        if($teacher_id){
            $query->where('tbl_teachers_payments.TeacherID', $teacher_id);
        }
        

        $results = $query->get();       
        
        if(count($results) == 0){
            return redirect()->back()->with('notFound', 'لايوجد مدفوعات تمت بناءا علي بحثك');
        }else{
            return view('back.reports.teacher_salary.pdf' , compact('pageNameAr', 'results', 'teacher_id', 'from', 'to'));
        }
    }
}