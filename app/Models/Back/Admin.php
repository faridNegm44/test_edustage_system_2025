<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $fillable = ['user_id', 'phone', 'gender', 'birth_date', 'nat_id', 'image', 'address', 'notes'];
}
