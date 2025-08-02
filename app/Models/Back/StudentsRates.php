<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsRates extends Model
{
    public $timestamps = false;

    protected $table = 'tbl_eval';
    protected $fillable = ['Eval_ID', 'Eval_Date', 'Eval_GroupID', 'Eval_TeacherID', 'Eval_Years_Mat', 'Eval_StudentID', 'Eval_TeacherComment', 'Eval_TeacherSugg', 'Eval_Count', 'Eval_Att', 'Eval_Part', 'Eval_Eval', 'Eval_HW', 'Eval_Degree', 'Eval_Month', 'Eval_Year', 'Eval_Total'];
}
