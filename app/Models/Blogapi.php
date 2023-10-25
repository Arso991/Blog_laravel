<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Blogapi extends Model{
    protected $fillable = ['posts'];
    protected $table = 'blog';

    public function commentaire(){
        return $this->hasMany(Comment::class, "blog_id", "id");
    }
}