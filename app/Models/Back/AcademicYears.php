<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYears extends Model
{
    use HasFactory;

    protected $table = 'academic_years';
    protected $fillable = [
        'name', 'start', 'end', 'status', 'notes',
    ];
}
