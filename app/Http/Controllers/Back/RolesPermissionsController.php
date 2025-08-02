<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\RolesPermissions;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class RolesPermissionsController extends Controller
{
    public function index()
    {
        if((userPermissions()->roles_permissions_view)){
            $pageNameAr = 'الأذونات والتراخيص';
            $pageNameEn = 'roles_permissions';
    
            return view('back.roles_permissions.index', compact('pageNameAr' , 'pageNameEn'));
        }else{
            return redirect('/')->with(['notAuth' => 'عذرًا، ليس لديك صلاحية لتنفيذ طلبك']);
        }  
        
    }

    public function create()
    {
        if((userPermissions()->roles_permissions_create)){
            $pageNameAr = 'الأذونات والتراخيص';
            $pageNameEn = 'roles_permissions';
    
            return view('back.roles_permissions.add', compact('pageNameAr' , 'pageNameEn'));
        }else{
            return redirect('/')->with(['notAuth' => 'عذرًا، ليس لديك صلاحية لتنفيذ طلبك']);
        }  
    }

    public function store(Request $request)
    {
        //dd(request()->all());
        $this->validate($request , [
            'role_name' => 'required|max:100|unique:roles_permissions,role_name',
        ],[
            'role_name.required' => 'اسم الإذن مطلوب',
            'role_name.unique' => 'اسم الإذن مستخدم من قبل',
        ]);

        DB::table('roles_permissions')->insert([
            // start first
            'role_name' => request('role_name'),
            'financialYears_create' => request('financialYears_create') ? 1 : 0, 
            'financialYears_update' => request('financialYears_update') ? 1 : 0, 
            'financialYears_view' => request('financialYears_view') ? 1 : 0, 
            'stores_create' => request('stores_create') ? 1 : 0, 
            'stores_update' => request('stores_update') ? 1 : 0, 
            'stores_view' => request('stores_view') ? 1 : 0, 
            'stores_delete' => request('stores_delete') ? 1 : 0, 
            'financial_treasury_create' => request('financial_treasury_create') ? 1 : 0, 
            'financial_treasury_update' => request('financial_treasury_update') ? 1 : 0, 
            'financial_treasury_view' => request('financial_treasury_view') ? 1 : 0, 
            'financial_treasury_delete' => request('financial_treasury_delete') ? 1 : 0, 
            'units_create' => request('units_create') ? 1 : 0, 
            'units_update' => request('units_update') ? 1 : 0, 
            'units_view' => request('units_view') ? 1 : 0, 
            'units_delete' => request('units_delete') ? 1 : 0, 
            'companies_create' => request('companies_create') ? 1 : 0, 
            'companies_update' => request('companies_update') ? 1 : 0, 
            'companies_view' => request('companies_view') ? 1 : 0, 
            'companies_delete' => request('companies_delete') ? 1 : 0, 
            'productsCategories_create' => request('productsCategories_create') ? 1 : 0, 
            'productsCategories_update' => request('productsCategories_update') ? 1 : 0, 
            'productsCategories_view' => request('productsCategories_view') ? 1 : 0, 
            'productsCategories_delete' => request('productsCategories_delete') ? 1 : 0, 
            'products_sub_category_create' => request('products_sub_category_create') ? 1 : 0, 
            'products_sub_category_update' => request('products_sub_category_update') ? 1 : 0, 
            'products_sub_category_view' => request('products_sub_category_view') ? 1 : 0, 
            'products_sub_category_delete' => request('products_sub_category_delete') ? 1 : 0, 
            'products_create' => request('products_create') ? 1 : 0, 
            'products_update' => request('products_update') ? 1 : 0, 
            'products_view' => request('products_view') ? 1 : 0, 
            'products_delete' => request('products_delete') ? 1 : 0, 
            'products_report_view' => request('products_report_view') ? 1 : 0, 
            'taswea_products_create' => request('taswea_products_create') ? 1 : 0, 
            'taswea_products_view' => request('taswea_products_view') ? 1 : 0, 
            'transfer_between_stores_create' => request('transfer_between_stores_create') ? 1 : 0, 
            'transfer_between_stores_view' => request('transfer_between_stores_view') ? 1 : 0, 
            'clients_create' => request('clients_create') ? 1 : 0, 
            'clients_update' => request('clients_update') ? 1 : 0, 
            'clients_view' => request('clients_view') ? 1 : 0, 
            'clients_delete' => request('clients_delete') ? 1 : 0, 
            'clients_report_view' => request('clients_report_view') ? 1 : 0, 
            'clients_account_statement_view' => request('clients_account_statement_view') ? 1 : 0, 
            'suppliers_create' => request('suppliers_create') ? 1 : 0, 
            'suppliers_update' => request('suppliers_update') ? 1 : 0, 
            'suppliers_view' => request('suppliers_view') ? 1 : 0, 
            'suppliers_delete' => request('suppliers_delete') ? 1 : 0, 
            'suppliers_report_view' => request('suppliers_report_view') ? 1 : 0, 
            'suppliers_account_statement_view' => request('suppliers_account_statement_view') ? 1 : 0, 
            'taswea_client_supplier_create' => request('taswea_client_supplier_create') ? 1 : 0, 
            'taswea_client_supplier_view' => request('taswea_client_supplier_view') ? 1 : 0, 
            'partners_create' => request('partners_create') ? 1 : 0, 
            'partners_update' => request('partners_update') ? 1 : 0, 
            'partners_view' => request('partners_view') ? 1 : 0, 
            'partners_delete' => request('partners_delete') ? 1 : 0, 
            'partners_report_view' => request('partners_report_view') ? 1 : 0, 
            'partners_account_statement_view' => request('partners_account_statement_view') ? 1 : 0, 
            'taswea_partners_create' => request('taswea_partners_create') ? 1 : 0, 
            'taswea_partners_view' => request('taswea_partners_view') ? 1 : 0, 
            'sales_create' => request('sales_create') ? 1 : 0, 
            'sales_return' => request('sales_return') ? 1 : 0, 
            'sales_view' => request('sales_view') ? 1 : 0, 
            'sales_return_view' => request('sales_return_view') ? 1 : 0, 
            'products_stock_alert_view' => request('products_stock_alert_view') ? 1 : 0, 
            'purchases_create' => request('purchases_create') ? 1 : 0, 
            'purchases_return' => request('purchases_return') ? 1 : 0, 
            'purchases_view' => request('purchases_view') ? 1 : 0, 
            'purchases_return_view' => request('purchases_return_view') ? 1 : 0, 
            'treasury_bills_create' => request('treasury_bills_create') ? 1 : 0, 
            'treasury_bills_view' => request('treasury_bills_view') ? 1 : 0, 
            'treasury_bills_report_view' => request('treasury_bills_report_view') ? 1 : 0, 
            'transfer_between_storages_create' => request('transfer_between_storages_create') ? 1 : 0, 
            'transfer_between_storages_view' => request('transfer_between_storages_view') ? 1 : 0, 
            'expenses_create' => request('expenses_create') ? 1 : 0, 
            'expenses_view' => request('expenses_view') ? 1 : 0, 
            'expenses_delete' => request('expenses_delete') ? 1 : 0, 
            'expenses_report_view' => request('expenses_report_view') ? 1 : 0, 
            'users_create' => request('users_create') ? 1 : 0, 
            'users_update' => request('users_update') ? 1 : 0, 
            'users_view' => request('users_view') ? 1 : 0, 
            'users_delete' => request('users_delete') ? 1 : 0, 
            'settings_update' => request('settings_update') ? 1 : 0, 
            'settings_view' => request('settings_view') ? 1 : 0, 
            'roles_permissions_create' => request('roles_permissions_create') ? 1 : 0, 
            'roles_permissions_update' => request('roles_permissions_update') ? 1 : 0, 
            'roles_permissions_view' => request('roles_permissions_view') ? 1 : 0, 
            'roles_permissions_delete' => request('roles_permissions_delete') ? 1 : 0,
            'tax_bill_view' => request('tax_bill_view') ? 1 : 0,
            'discount_bill_view' => request('discount_bill_view') ? 1 : 0,
            'cost_price_view' => request('cost_price_view') ? 1 : 0,
            'created_at' => now(),
            // end first
            
            
            // start second
            'total_sell_bill_today_view' => request('total_sell_bill_today_view') ? 1 : 0,
            'total_profit_today_view' => request('total_profit_today_view') ? 1 : 0,
            'total_money_on_financial_treasury_view' => request('total_money_on_financial_treasury_view') ? 1 : 0,
            'top_products_view' => request('top_products_view') ? 1 : 0,
            'top_clients_view' => request('top_clients_view') ? 1 : 0,
            'profit_view' => request('profit_view') ? 1 : 0,
            // end second            
            
            
            // start third
            'receipts_create' => request('receipts_create') ? 1 : 0,
            'receipts_update' => request('receipts_update') ? 1 : 0,
            'receipts_view' => request('receipts_view') ? 1 : 0,
            'receipts_delete' => request('receipts_delete') ? 1 : 0,
            'receipts_take_money' => request('receipts_take_money') ? 1 : 0,
            // end third            
        ]);
        
        return redirect()->back();
        //return redirect()->to('/roles_permissions');
    }

    public function edit($id)
    {
        if((userPermissions()->roles_permissions_update)){
            $find = RolesPermissions::where('id', $id)->first();
            $pageNameAr = 'الأذونات والتراخيص';
            $pageNameEn = 'roles_permissions';
    
            return view('back.roles_permissions.edit', compact('find', 'pageNameAr', 'pageNameEn'));	
        }else{
            return redirect('/')->with(['notAuth' => 'عذرًا، ليس لديك صلاحية لتنفيذ طلبك']);
        }  
    }

    public function update(Request $request, $id)
    {
        $this->validate($request , [
            'role_name' => 'required|max:100|unique:roles_permissions,role_name,'.$id,
        ],[
            'role_name.required' => 'اسم الإذن مطلوب',
            'role_name.unique' => 'اسم الإذن مستخدم من قبل',
        ]);

        DB::table('roles_permissions')->where('id', $id)->update([
            // start first
            'role_name' => request('role_name'),
            'financialYears_create' => request('financialYears_create') ? 1 : 0, 
            'financialYears_update' => request('financialYears_update') ? 1 : 0, 
            'financialYears_view' => request('financialYears_view') ? 1 : 0, 
            'stores_create' => request('stores_create') ? 1 : 0, 
            'stores_update' => request('stores_update') ? 1 : 0, 
            'stores_view' => request('stores_view') ? 1 : 0, 
            'stores_delete' => request('stores_delete') ? 1 : 0, 
            'financial_treasury_create' => request('financial_treasury_create') ? 1 : 0, 
            'financial_treasury_update' => request('financial_treasury_update') ? 1 : 0, 
            'financial_treasury_view' => request('financial_treasury_view') ? 1 : 0, 
            'financial_treasury_delete' => request('financial_treasury_delete') ? 1 : 0, 
            'units_create' => request('units_create') ? 1 : 0, 
            'units_update' => request('units_update') ? 1 : 0, 
            'units_view' => request('units_view') ? 1 : 0, 
            'units_delete' => request('units_delete') ? 1 : 0, 
            'companies_create' => request('companies_create') ? 1 : 0, 
            'companies_update' => request('companies_update') ? 1 : 0, 
            'companies_view' => request('companies_view') ? 1 : 0, 
            'companies_delete' => request('companies_delete') ? 1 : 0, 
            'productsCategories_create' => request('productsCategories_create') ? 1 : 0, 
            'productsCategories_update' => request('productsCategories_update') ? 1 : 0, 
            'productsCategories_view' => request('productsCategories_view') ? 1 : 0, 
            'productsCategories_delete' => request('productsCategories_delete') ? 1 : 0, 
            'products_sub_category_create' => request('products_sub_category_create') ? 1 : 0, 
            'products_sub_category_update' => request('products_sub_category_update') ? 1 : 0, 
            'products_sub_category_view' => request('products_sub_category_view') ? 1 : 0, 
            'products_sub_category_delete' => request('products_sub_category_delete') ? 1 : 0, 
            'products_create' => request('products_create') ? 1 : 0, 
            'products_update' => request('products_update') ? 1 : 0, 
            'products_view' => request('products_view') ? 1 : 0, 
            'products_delete' => request('products_delete') ? 1 : 0, 
            'products_report_view' => request('products_report_view') ? 1 : 0, 
            'taswea_products_create' => request('taswea_products_create') ? 1 : 0, 
            'taswea_products_view' => request('taswea_products_view') ? 1 : 0, 
            'transfer_between_stores_create' => request('transfer_between_stores_create') ? 1 : 0, 
            'transfer_between_stores_view' => request('transfer_between_stores_view') ? 1 : 0, 
            'clients_create' => request('clients_create') ? 1 : 0, 
            'clients_update' => request('clients_update') ? 1 : 0, 
            'clients_view' => request('clients_view') ? 1 : 0, 
            'clients_delete' => request('clients_delete') ? 1 : 0, 
            'clients_report_view' => request('clients_report_view') ? 1 : 0, 
            'clients_account_statement_view' => request('clients_account_statement_view') ? 1 : 0, 
            'suppliers_create' => request('suppliers_create') ? 1 : 0, 
            'suppliers_update' => request('suppliers_update') ? 1 : 0, 
            'suppliers_view' => request('suppliers_view') ? 1 : 0, 
            'suppliers_delete' => request('suppliers_delete') ? 1 : 0, 
            'suppliers_report_view' => request('suppliers_report_view') ? 1 : 0, 
            'suppliers_account_statement_view' => request('suppliers_account_statement_view') ? 1 : 0, 
            'taswea_client_supplier_create' => request('taswea_client_supplier_create') ? 1 : 0, 
            'taswea_client_supplier_view' => request('taswea_client_supplier_view') ? 1 : 0, 
            'partners_create' => request('partners_create') ? 1 : 0, 
            'partners_update' => request('partners_update') ? 1 : 0, 
            'partners_view' => request('partners_view') ? 1 : 0, 
            'partners_delete' => request('partners_delete') ? 1 : 0, 
            'partners_report_view' => request('partners_report_view') ? 1 : 0, 
            'partners_account_statement_view' => request('partners_account_statement_view') ? 1 : 0, 
            'taswea_partners_create' => request('taswea_partners_create') ? 1 : 0, 
            'taswea_partners_view' => request('taswea_partners_view') ? 1 : 0, 
            'sales_create' => request('sales_create') ? 1 : 0, 
            'sales_return' => request('sales_return') ? 1 : 0, 
            'sales_view' => request('sales_view') ? 1 : 0, 
            'sales_return_view' => request('sales_return_view') ? 1 : 0, 
            'products_stock_alert_view' => request('products_stock_alert_view') ? 1 : 0, 
            'purchases_create' => request('purchases_create') ? 1 : 0, 
            'purchases_return' => request('purchases_return') ? 1 : 0, 
            'purchases_view' => request('purchases_view') ? 1 : 0, 
            'purchases_return_view' => request('purchases_return_view') ? 1 : 0, 
            'treasury_bills_create' => request('treasury_bills_create') ? 1 : 0, 
            'treasury_bills_view' => request('treasury_bills_view') ? 1 : 0, 
            'treasury_bills_report_view' => request('treasury_bills_report_view') ? 1 : 0, 
            'transfer_between_storages_create' => request('transfer_between_storages_create') ? 1 : 0, 
            'transfer_between_storages_view' => request('transfer_between_storages_view') ? 1 : 0, 
            'expenses_create' => request('expenses_create') ? 1 : 0, 
            'expenses_view' => request('expenses_view') ? 1 : 0, 
            'expenses_delete' => request('expenses_delete') ? 1 : 0, 
            'expenses_report_view' => request('expenses_report_view') ? 1 : 0, 
            'users_create' => request('users_create') ? 1 : 0, 
            'users_update' => request('users_update') ? 1 : 0, 
            'users_view' => request('users_view') ? 1 : 0, 
            'users_delete' => request('users_delete') ? 1 : 0, 
            'settings_update' => request('settings_update') ? 1 : 0, 
            'settings_view' => request('settings_view') ? 1 : 0, 
            'roles_permissions_create' => request('roles_permissions_create') ? 1 : 0, 
            'roles_permissions_update' => request('roles_permissions_update') ? 1 : 0, 
            'roles_permissions_view' => request('roles_permissions_view') ? 1 : 0, 
            'roles_permissions_delete' => request('roles_permissions_delete') ? 1 : 0,
            'tax_bill_view' => request('tax_bill_view') ? 1 : 0,
            'discount_bill_view' => request('discount_bill_view') ? 1 : 0,
            'cost_price_view' => request('cost_price_view') ? 1 : 0,
            'updated_at' => now(),
            // end first
            
            
            // start second
            'total_sell_bill_today_view' => request('total_sell_bill_today_view') ? 1 : 0,
            'total_profit_today_view' => request('total_profit_today_view') ? 1 : 0,
            'total_money_on_financial_treasury_view' => request('total_money_on_financial_treasury_view') ? 1 : 0,
            'top_products_view' => request('top_products_view') ? 1 : 0,
            'top_clients_view' => request('top_clients_view') ? 1 : 0,
            'profit_view' => request('profit_view') ? 1 : 0,
            // end second       
            
            
            // start third
            'receipts_create' => request('receipts_create') ? 1 : 0,
            'receipts_update' => request('receipts_update') ? 1 : 0,
            'receipts_view' => request('receipts_view') ? 1 : 0,
            'receipts_delete' => request('receipts_delete') ? 1 : 0,
            'receipts_take_money' => request('receipts_take_money') ? 1 : 0,
            // end third                 
        ]);
        
        return redirect()->back();
        //return redirect()->to('roles_permissions');
    }

    public function destroy($id, Request $request)
    {
        if((userPermissions()->roles_permissions_delete)){
            RolesPermissions::findOrFail($id)->delete();	
        }else{
            return redirect('/')->with(['notAuth' => 'عذرًا، ليس لديك صلاحية لتنفيذ طلبك']);
        }  
        
    }







    ///////////////////////////////////////////////  datatable_roles_permissions  /////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function datatable()
    {
        $all = RolesPermissions::all();
        return DataTables::of($all)
        ->addColumn('id', function($res){
            return "<span style=''>".$res->id."</span>";
        })
        ->addColumn('role_name', function($res){
            return "<span style=''>".$res->role_name."</span>";
        })
        ->addColumn('action', function($res){
            return 
                '
                    <a href="'.url('roles_permissions/edit/'.$res->id).'" type="button" class="btn btn-sm btn-outline-primary edit" data-effect="effect-scale" data-placement="top" data-toggle="tooltip" title="تعديل" res_id="'.$res->id.'">
                        <i class="fas fa-marker"></i>
                    </a>
                ';

        })
        ->rawColumns(['id', 'role_name', 'action'])
        ->make(true);
    }

}