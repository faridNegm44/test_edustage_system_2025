<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    protected $table = 'tbl_parents';
    protected $fillable = ['ID', 'TheDate1', 'TheEmail', 'ThePass', 'TheCode', 'TheName0', 'TheName1', 'TheName2', 'TheName3', 'NatID', 'CityID', 'ThePhone1', 'ThePhone2', 'TheNotes', 'TheStatus', 'TheStatusDate', 'PrevRaseed'];
}
