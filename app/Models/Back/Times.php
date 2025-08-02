<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Times extends Model
{
    protected $table = 'times';
    protected $fillable = ['time', 'am_pm', 'order'];
}
