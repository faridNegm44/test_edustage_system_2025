<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'tbl_teachers';
    protected $fillable = ['ID', 'TheDate1', 'TheName', 'NatID', 'CityID', 'TheBirthDate', 'ThePhone1', 'ThePhone2', 'TheEmail', 'TheCurrentJob', 'TheExNumber', 'TheMethod', 'HaveEx', 'TheExExplain', 'HaveLap', 'HaveHead', 'HaveNet', 'TheStatus', 'TheStatusDate', 'ThePass', 'PrevRaseed'];
}
