<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesPermissions extends Model
{
    protected $table = 'roles_permissions';
    protected $fillable = [
        //////////////////////////// start first  ////////////////////////////
        //////////////////////////// start first  ////////////////////////////
        'role_name', 'financialYears_create', 'financialYears_update', 'financialYears_view', 'stores_create', 'stores_update', 'stores_view', 'stores_delete', 'financial_treasury_create', 'financial_treasury_update', 'financial_treasury_view', 'financial_treasury_delete', 'units_create', 'units_update', 'units_view', 'units_delete', 'companies_create', 'companies_update', 'companies_view', 'companies_delete', 'productsCategories_create', 'productsCategories_update', 'productsCategories_view', 'productsCategories_delete', 'products_sub_category_create', 'products_sub_category_update', 'products_sub_category_view', 'products_sub_category_delete', 'products_create', 'products_update', 'products_view', 'products_delete', 'products_report_view', 'taswea_products_create', 'taswea_products_view', 'transfer_between_stores_create', 'transfer_between_stores_view', 'clients_create', 'clients_update', 'clients_view', 'clients_delete', 'clients_report_view', 'clients_account_statement_view', 'suppliers_create', 'suppliers_update', 'suppliers_view', 'suppliers_delete', 'suppliers_report_view', 'suppliers_account_statement_view', 'taswea_client_supplier_create', 'taswea_client_supplier_view', 'partners_create', 'partners_update', 'partners_view', 'partners_delete', 'partners_report_view', 'partners_account_statement_view', 'taswea_partners_create', 'taswea_partners_view', 'sales_create', 'sales_return', 'sales_view', 'sales_return_view', 'products_stock_alert_view', 'purchases_create', 'purchases_return', 'purchases_view', 'purchases_return_view', 'treasury_bills_create', 'treasury_bills_view', 'treasury_bills_report_view', 'transfer_between_storages_create', 'transfer_between_storages_view', 'expenses_create', 'expenses_view', 'expenses_delete', 'expenses_report_view', 'users_create', 'users_update', 'users_view', 'users_delete', 'settings_update', 'settings_view', 'roles_permissions_create', 'roles_permissions_update', 'roles_permissions_view', 'roles_permissions_delete'
        //////////////////////////// end first  ////////////////////////////
        //////////////////////////// end first  ////////////////////////////
    ];
}
