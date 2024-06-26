<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryImage extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['folder', 'file','date','user','main'];
}
