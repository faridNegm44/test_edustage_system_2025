<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'action', 'table_name', 'record_id', 'old_data', 'new_data', 'user_agent',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];
}
