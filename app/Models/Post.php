<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $primaryKey = 'number';

    protected $fillable = ['number', 'id', 'nickname', 'subject', 'content', 'regist_day', 'view', 'file_name', 'file_type', 'file_copied'];

    public $timestamps = false;
}
