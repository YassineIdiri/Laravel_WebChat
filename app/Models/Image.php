<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    
    public $timestamps = false;
    use HasFactory;
    protected $fillable = ['path', 'article_id','main'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
