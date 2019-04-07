<?php


namespace App\Models;


class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = ['title', 'body', 'visible', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->using(Post_Tag::class);
    }

    public function setTags($tags = [])
    {
        $created = [];

        if (!$tags) {
            $this->tags()->detach();
            return true;
        }

        foreach ($tags as $tag) {
            $newTag = Tag::findByName($tag) ?? Tag::create(['name' => $tag]);

            if (!$newTag->save()) {
                return false;
            }
            $created[] = $newTag->id;
        }
        if (!$this->tags()->sync($created)) return false;

        return true;
    }

    public function delete()
    {
        $this->tags()->detach();
        return parent::delete();
    }
}
