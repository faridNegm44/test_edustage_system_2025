<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Students extends Authenticatable
{
    protected $table = 'tbl_teachers';
    protected $fillable = ['ID', 'TheDate1', 'TheName', 'ParentID', 'NatID', 'CityID', 'ThePhone', 'TheEmail', 'ThePassword', 'TheEduType', 'TheTestType', 'TheExplain', 'TheNotes', 'TheStatus', 'TheStatusDate', 'TheLangID', 'academic_year'];
}
