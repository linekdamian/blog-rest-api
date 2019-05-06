<?php


namespace App\Models\Translations;


use App\Models\Post;
use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CategoryTranslation
 * @package App\Models\Translations
 */
class PostTranslation extends Model
{
    /**
     * @var string
     */
    protected $table = 'post_translations';

    /**
     * @var array
     */
    protected $fillable = ['title', 'slug', 'body', 'language_id', 'post_id'];

    /**
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->setSlug();
    }
}
