<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Rooms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PartnersPaymentsController extends Controller
{
    public function index()
    {                               
        $pageNameAr = 'مسحوبات الشركاء';
        $pageNameEn = 'partners_payments';
        $partners = DB::table('partners')->orderBy('name', 'asc')->where('status', 1)->get();
        $wallets = DB::table('tblwallets')->orderBy('WalletName', 'asc')->get();
        $academic_years = DB::table('academic_years')->orderBy('id', 'asc')->get();
        
        return view('back.partners_payments.index' , compact('pageNameAr' , 'pageNameEn', 'partners', 'wallets', 'academic_years'));
    }

    public function store(Request $request)
    {
        if (request()->ajax()){
            $this->validate($request, [
                'TheDate'     => 'required|date',
                'PartnerID'   => 'required|integer|exists:partners,id',
                'TheAmount'   => 'required|numeric',
                'WalletID'    => 'required|integer|exists:tblwallets,WalletID',
                'TheNotes'    => 'nullable|string',
            ], [
                'required' => ':attribute مطلوب.',
                'string'   => ':attribute غير صحيح.',
                'numeric'  => ':attribute يجب أن يكون رقمًا.',
                'integer'  => ':attribute غير صحيح.',
                'min'      => ':attribute يجب أن يكون على الأقل :min.',
                'date'     => ':attribute يجب أن يكون تاريخًا صحيحًا.',
                'exists'   => ':attribute غير موجود في قاعدة البيانات.',
            ], [
                'TheDate'    => 'تاريخ الدفع',
                'PartnerID'  => 'الشريك',
                'TheAmount'  => 'المبلغ',
                'WalletID'   => 'المحفظة',
                'TheNotes'   => 'ملاحظات',
            ]);            

            $data = request()->except('_token');
            $data['academic_year'] = GetAcademicYaer();

            DB::table('tbl_partners_payments')->insert($data);
        }
    }


    public function datatable(Request $request)
    {
        $academic_year = $request->academic_year;
        $from = $request->from ?? null;
        $to = $request->to ?? null;

        $query = DB::table('tbl_partners_payments')
                ->leftJoin('partners', 'partners.id', 'tbl_partners_payments.PartnerID')
                ->leftJoin('tblwallets', 'tblwallets.WalletID', 'tbl_partners_payments.WalletID')
                ->leftJoin('academic_years', 'academic_years.id', 'tbl_partners_payments.academic_year')
                ->select(
                    'tbl_partners_payments.*',
                    'partners.name as partnerName', 
                    'tblwallets.WalletName', 
                    'academic_years.name as academicYearName', 
                );

        if ($from && $to) {
            $query->whereBetween('tbl_partners_payments.TheDate', [$from, $to]);
        } elseif ($from) {
            $query->where('tbl_partners_payments.TheDate', '>=', $from);
        } elseif ($to) {
            $query->where('tbl_partners_payments.TheDate', '<=', $to);
        }
        
        if($academic_year){
            $query->where('tbl_partners_payments.academic_year', $academic_year);
        }
        
        $all = $query->get();

        return DataTables::of($all)
            ->addColumn('TheAmount', function($res){
                return "<span class='badge badge-primary' style='font-size: 15px !important;width: 80%;'>".display_number($res->TheAmount)."</span>";
            })      
            ->addColumn('partnerName', function($res){
                return $res->partnerName;
            })
            ->addColumn('TheNotes', function($res){
                return '<span data-bs-toggle="popover" data-bs-placement="bottom" title="'.$res->TheNotes.'">
                    '.Str::limit($res->TheNotes, 40).'
                </span>';
            })      
            ->rawColumns(['TheAmount', 'partnerName', 'TheNotes'])
            ->toJson();
    }
}