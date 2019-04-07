<?php


namespace App\Models;


class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = ['name'];

    public function posts()
    {
        return $this->belongsToMany(Post::class)->using(Post_Tag::class);
    }

    public static function findByName($name)
    {
        return (new static)::where('name', $name)->first();
    }
}
