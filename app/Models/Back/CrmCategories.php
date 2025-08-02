<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmCategories extends Model
{
    protected $table = 'crm_categories';
    protected $fillable = ['name'];
}
