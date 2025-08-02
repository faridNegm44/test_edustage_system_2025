<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'name', 'description', 'footer_text', 'address', 'city', 'zip_code', 'email', 'phone1', 'phone2', 'logo', 'fav_icon', 'mail_driver', 'from', 'to', 'host', 'port', 'encryption', 'username', 'password', 'theme'
    ];
}
