<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use App\Models\ArticleUser;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Order;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasFactory, Notifiable;
    

    public $timestamps = false;

    //retounr les commentaire (la ou ce user est en clé externe dans la table comments)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function article()
    {
        return $this->hasMany(Article::class);
    }

    //retounr les article achetés (qui se trouvent dans la tabel de jonction abec le user en question)
    public function panier()
    {
        return $this->hasMany(ArticleUser::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
