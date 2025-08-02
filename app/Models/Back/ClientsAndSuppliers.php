<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsAndSuppliers extends Model
{
    protected $table = 'clients_and_suppliers';
    protected $fillable = [
        'client_supplier_type', 'code', 'name', 'email', 'address', 'phone', 'image', 'type_payment', 'debit', 'debit_limit', 'money', 'status', 'commercial_register', 'tax_card', 'vat_registration_code', 'name_of_commissioner', 'phone_of_commissioner', 'note'
    ];

    public function clientsAndSuppliersTypeRelation(){
        return $this->belongsTo(PersonStatus::class, 'person_status');
    }
}
