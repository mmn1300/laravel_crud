<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $primaryKey = 'code';

    protected $fillable = ['code', 'id', 'password', 'nickname', 'email', 'phone_number', 'regist_day', 'level'];

    public $timestamps = true;
}
