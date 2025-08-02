<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTableRamadanMonth extends Model
{
    protected $table = 'time_tables_ramadan_month';
    protected $fillable = ['group_id', 'notes', 'day', 'date', 'class_type', 'times', 'from_to', 'room_id', 'user', 'group_to_colspan'];
}
