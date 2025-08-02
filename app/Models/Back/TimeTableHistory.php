<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTableHistory extends Model
{
    use HasFactory;
    protected $table = 'time_table_histories';
    protected $fillable = ['user_id', 'type_history', 'relation_id', 'times', 'group_id_time', 'class_type_time', 'day_time', 'date_time', 'room_id_time', 'user_room', 'notes_time'];
}
