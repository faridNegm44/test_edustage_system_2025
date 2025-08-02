<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ActivityLogHelper;

class CrmColumnsValues extends Model
{
    protected $table = 'crm_columns_values';
    protected $fillable = ['column_id', 'parent_id', 'value'];
}
