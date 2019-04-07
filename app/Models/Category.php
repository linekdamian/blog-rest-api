<?php


namespace App\Models;


class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'description'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
