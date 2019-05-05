<?php


namespace App\Models\Translations;


use App\Models\Category;
use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TagTranslation
 * @package App\Models\Translations
 */
class TagTranslation extends Model
{
    /**
     * @var string
     */
    protected $table = 'tag_translations';

    /**
     * @var array
     */
    protected $fillable = ['name', 'language_id', 'tag_id'];

    /**
     * @return BelongsTo
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
