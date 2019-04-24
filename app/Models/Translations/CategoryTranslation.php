<?php


namespace App\Models\Translations;


use App\Models\Category;
use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CategoryTranslation
 * @package App\Models\Translations
 */
class CategoryTranslation extends Model
{
    /**
     * @var string
     */
    protected $table = 'category_translations';

    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'language_id', 'category_id'];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
