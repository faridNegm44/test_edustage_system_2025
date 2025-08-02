
@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    <style>
        tbody tr td {
            padding: 5px !important;
        }
        #selectAll{
            width: 2em;
            height: 2em;
        }
        input[type="checkbox"]{
            width: 1.5em;
            height: 1.5em;
            vertical-align: top;
            background-color: #fff;
            border: 1px solid #e3d9da;
            margin: 0px 8px;
            position: relative;
            top: 0px !important;
        }
        .badge{
            padding: 3px 10px 5px !important;
            position: relative;
            top: 5px;
            font-size: 80% !important;
        }
        .me-3{
            width: 140px !important;
        }

        tbody tr td {
            padding: 0px !important;
        }
    </style>
@endsection

@section('footer')
    <script>
        $(document).ready(function () {
            $('#selectAll').click(function(event) {
                if(this.checked) {
                    $('input[type="checkbox"]').each(function() {
                        this.checked = true;
                    });
                } else {
                    $('input[type="checkbox"]').each(function() {
                        this.checked = false;
                    });
                }
            });
        });
    </script>
@endsection



@section('content')
    <div class="container" style="padding: 10px 20px;">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">{{ $pageNameAr }}</h4>
                </div>
            </div>
        </div>
        <!-- breadcrumb -->

        <div class="card" style="padding: 10px;margin: 10px;" id="permisions">
            @php
                $models = [
                    // start first add
                        'academic_years', 'rooms', 'types_of_education', 'nationalities', 'places_of_stay', 'teachers', 'teacher_subjects', 'partners', 'subjects', 'parents', 'students', 'students_wishlist', 'teacher_accounting_type', 'groups', 'groups_sessions', 'financial_categories', 'partners_payments', 'wallets', 'crm_columns_name', 'students_estimates', 'times', 'time_table', 'time_table_ramadan_month', 'users', 'roles_permissions', 'settings'
                    // end first add
                    
                    
                    // start second add
                        
                    // end second add
                    
                    
                    // start third add
                        
                    // end third add
                    
                ];
                $count = 1;
            @endphp

            <form action="{{ url('roles_permissions/store') }}" method="post">
                @csrf
                <div>
                    <div style="padding: 0px 5px 20px;">
                        <label for="role_name">اسم الإذن</label>

                        <input type="text" class="form-control" name="role_name" id="role_name" placeholder="اسم الإذن" value="{{ old('role_name') }}" />

                        @if($errors->has('role_name'))
                            <div class="error text-danger">{{ $errors->first('role_name') }}</div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover nowrap;">
                            <thead class="bg bg-black-5">
                                <tr>
                                    <td style="color: #fff !important;padding: 10px;">#</td>
                                    <td style="color: #fff !important;padding: 10px;">الأسم</td>
                                    <td style="color: #fff !important;padding: 10px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                            <label class="form-check-label text-white" for="selectAll">إختر الكل</label>
                                        </div>
                                    </td>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($models as $model)
                                    <tr style="" id="{{ $model }}">
                                        <td class="text-center">{{ $count++ }}</td>
                                        <td class="text-nowrap fw-semibold">@lang('app.'.$model)</td>
                                        <td>
                                            <div class="d-flex">
                                                @if($model != 'settings')
                                                    <div class="form-check me-3 me-lg-5" id="{{ $model }}_take_moneyview_div">
                                                        <input class="form-check-input" type="checkbox" name="{{ $model }}_view" {{ old(''.$model.'_view') ? 'checked' : '' }} id="{{ $model }}_view"/>
                                                        <label class="form-check-label badge badge-purple rounded-pill" for="{{ $model }}_view">عرض</label>
                                                    </div>
                                                @endif

                                                @if(
                                                    $model != 'clients_report' &&
                                                    $model != 'clients_account_statement' &&
                                                    $model != 'suppliers_report' &&
                                                    $model != 'suppliers_account_statement' &&
                                                    $model != 'partners_report' &&
                                                    $model != 'partners_account_statement' &&
                                                    $model != 'sales_create' &&
                                                    $model != 'sales_return' &&
                                                    $model != 'products_stock_alert' &&
                                                    $model != 'products_report' &&
                                                    $model != 'purchases_create' &&
                                                    $model != 'purchases_return' &&
                                                    $model != 'treasury_bills_create' &&  
                                                    $model != 'treasury_bills_report' && 
                                                    $model != 'total_sell_bill_today' &&
                                                    $model != 'total_profit_today' &&
                                                    $model != 'total_money_on_financial_treasury' &&
                                                    $model != 'top_products' &&
                                                    $model != 'top_clients' &&
                                                    $model != 'profit' &&                                                 
                                                    $model != 'settings' &&
                                                    $model != 'tax_bill' &&
                                                    $model != 'discount_bill' &&
                                                    $model != 'cost_price' &&
                                                    
                                                    $model != 'expenses_report' 
                                                )
                                                    <div class="form-check me-3 me-lg-5" id="{{ $model }}_create_div">
                                                        <input class="form-check-input" type="checkbox" name="{{ $model }}_create" {{ old(''.$model.'_create') ? 'checked' : '' }} id="{{ $model }}_create"/>
                                                        <label class="form-check-label badge badge-success rounded-pill" for="{{ $model }}_create">اضافة</label>
                                                    </div>
                                                @endif
                                            
                                                @if(
                                                    $model != 'transfer_between_stores' &&
                                                    $model != 'taswea_products' &&
                                                    $model != 'clients_report' &&
                                                    $model != 'clients_account_statement' &&
                                                    $model != 'suppliers_report' &&
                                                    $model != 'suppliers_account_statement' &&
                                                    $model != 'taswea_client_supplier' &&
                                                    $model != 'partners_report' &&
                                                    $model != 'partners_account_statement' &&
                                                    $model != 'taswea_partners' &&
                                                    $model != 'sales' &&
                                                    $model != 'sales_create' &&
                                                    $model != 'sales_return' &&
                                                    $model != 'products_stock_alert' &&
                                                    $model != 'products_report' &&
                                                    $model != 'purchases' &&
                                                    $model != 'purchases_create' &&
                                                    $model != 'purchases_return' &&
                                                    $model != 'treasury_bills' &&
                                                    $model != 'treasury_bills_create' &&
                                                    $model != 'treasury_bills_report' &&
                                                    $model != 'transfer_between_storages' &&
                                                    $model != 'expenses' &&
                                                    $model != 'total_sell_bill_today' &&
                                                    $model != 'total_profit_today' &&
                                                    $model != 'total_money_on_financial_treasury' &&
                                                    $model != 'top_products' &&
                                                    $model != 'top_clients' &&
                                                    $model != 'profit' &&
                                                    $model != 'tax_bill' &&
                                                    $model != 'discount_bill' &&
                                                    $model != 'cost_price' &&
                                                    $model != 'expenses_report' 
                                                )
                                                    <div class="form-check me-3 me-lg-5" id="{{ $model }}_update_div">
                                                        <input class="form-check-input" type="checkbox" name="{{ $model }}_update" {{ old(''.$model.'_update') ? 'checked' : '' }} id="{{ $model }}_update"/>
                                                        <label class="form-check-label badge badge-info rounded-pill" for="{{ $model }}_update">تحديث</label>
                                                    </div>
                                                @endif

                                                @if(
                                                    $model != 'financialYears' &&
                                                    $model != 'transfer_between_stores' &&
                                                    $model != 'taswea_products' &&
                                                    $model != 'clients_report' &&
                                                    $model != 'clients_account_statement' &&
                                                    $model != 'suppliers_report' &&
                                                    $model != 'suppliers_account_statement' &&
                                                    $model != 'taswea_client_supplier' &&
                                                    $model != 'partners_report' &&
                                                    $model != 'partners_account_statement' &&
                                                    $model != 'taswea_partners' &&
                                                    $model != 'sales' &&
                                                    $model != 'sales_create' &&
                                                    $model != 'sales_return' &&
                                                    $model != 'products_stock_alert' &&
                                                    $model != 'products_report' &&
                                                    $model != 'purchases' &&
                                                    $model != 'purchases_create' &&
                                                    $model != 'purchases_return' &&
                                                    $model != 'treasury_bills' &&
                                                    $model != 'treasury_bills_create' &&
                                                    $model != 'treasury_bills_report' &&
                                                    $model != 'transfer_between_storages' &&
                                                    $model != 'expenses_report' &&
                                                    $model != 'total_sell_bill_today' &&
                                                    $model != 'total_profit_today' &&
                                                    $model != 'total_money_on_financial_treasury' &&
                                                    $model != 'top_products' &&
                                                    $model != 'top_clients' &&
                                                    $model != 'profit' &&
                                                    $model != 'tax_bill' &&
                                                    $model != 'discount_bill' &&
                                                    $model != 'cost_price' &&
                                                    $model != 'settings'
                                                )
                                                    <div class="form-check me-3 me-lg-5" id="{{ $model }}_delete_div">
                                                        <input class="form-check-input" type="checkbox" name="{{ $model }}_delete" {{ old(''.$model.'_delete') ? 'checked' : '' }} id="{{ $model }}_delete"/>
                                                        <label class="form-check-label badge badge-danger rounded-pill" for="{{ $model }}_delete">حذف</label>
                                                    </div>
                                                @endif

                                                @if($model == 'receipts')
                                                    <div class="form-check me-3 me-lg-5" id="{{ $model }}_take_money_div" style="width: 170px !important;">
                                                        <input class="form-check-input" type="checkbox" name="{{ $model }}_take_money" {{ old(''.$model.'_take_money') ? 'checked' : '' }} id="{{ $model }}_take_money"/>
                                                        <label class="form-check-label badge badge-primary-transparent rounded-pill" for="{{ $model }}_take_money">تحصيل الايصال</label>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <br>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-success-gradient waves-effect waves-light" id="save" style="display: block;width: 20%;height: 50px;margin: 0 auto;">حفظ</button>
                    </div>
                </div>

            </form>
        </div>

    </div>
@endsection

