<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\ClientsAndSuppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportsGeneralFinancialController extends Controller
{
    public function index()
    {         
        //if((userPermissions()->clients_report_view)){
            $pageNameAr = '💰📊 الكشف المالي العام 🧾';        
            
            return view('back.reports.general_financial.index' , compact('pageNameAr'));
	
        //}else{
        //    return redirect('/')->with(['notAuth' => 'عذرًا، ليس لديك صلاحية لتنفيذ طلبك']);
        //}  
                  
    }
    
    public function result_pdf(Request $request)
    {                   
        $pageNameAr = '💰📊 الكشف المالي العام 🧾'; 

        $from = $request->from ? date('Y-m-d', strtotime($request->from)) : null;
        $to = $request->to ? date('Y-m-d', strtotime($request->to)) : null;


        $reportsTitles = [
            'withdrawals'        => "مسحوبات عن الفترة المحددة",
            'expenses'           => "مصاريف عن الفترة المحددة",
            'teacherPayments'    => "مدفوعات المدرسين عن الفترة المحددة",
            'parentPayments'     => "مدفوعات أولياء الأمور الفترة المحددة",
            'generalIncomes'     => "واردات متنوعة عن الفترة المحددة",
        ];
        
        dd($reportsTitles);


        $query = DB::table('tbl_parents_payments')
                    ->leftJoin('tbl_parents', 'tbl_parents.ID', 'tbl_parents_payments.ParentID')
                    ->leftJoin('tblwallets', 'tblwallets.WalletID', 'tbl_parents_payments.WalletID')
                    ->leftJoin('academic_years', 'academic_years.id', 'tbl_parents_payments.academic_year')
                    ->select(
                        'tbl_parents_payments.*',
                        'tbl_parents.TheName0', 
                        'tblwallets.WalletName', 
                        'academic_years.name as academicYearName',
                    )
                    ->orderBy('tbl_parents_payments.TheDate', 'asc');

        if ($from && $to) {
            $query->whereBetween('tbl_parents_payments.TheDate', [$from, $to]);
        } elseif ($from) {
            $query->where('tbl_parents_payments.TheDate', '>=', $from);
        } elseif ($to) {
            $query->where('tbl_parents_payments.TheDate', '<=', $to);
        }
        

        $results = $query->get();       

        if(count($results) == 0){
            return redirect()->back()->with('notFound', 'لايوجد مدفوعات تمت بناءا علي بحثك');
        }else{
            return view('back.reports.general_financial.pdf' , compact('pageNameAr', 'results', 'from', 'to'));
        }
    }
}