<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;
    protected $table = 'tbl_rooms';
    protected $fillable = ['RoomID', 'RoomName', 'RoomUser', 'RoomPass', 'status', 'created_at', 'updated_at'];
}
