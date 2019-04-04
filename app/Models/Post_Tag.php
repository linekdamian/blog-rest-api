<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;

class Post_Tag extends Pivot
{
    protected $table = 'posts_tags';

}
