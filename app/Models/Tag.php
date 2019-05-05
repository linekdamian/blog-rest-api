<?php


namespace App\Models;


use App\Models\Translations\TagTranslation;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;

class Tag extends Model
{
    /**
     * @var string
     */
    protected $table = 'tags';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @var array
     */
    protected $with = ['posts'];

    /**
     * @var array
     */
    protected $appends = ['name'];

    /**
     * @return belongsToMany
     */
    public function posts(): belongsToMany
    {
        return $this->belongsToMany(Post::class)->using(Post_Tag::class);
    }

    /**
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(TagTranslation::class);
    }

    /**
     * @param array $attributes
     * @return Tag|null
     */
    public static function create(array $attributes = []): ?Tag
    {
        DB::beginTransaction();
        try {
            $tag = new self();
            $tag->save();

            foreach (Language::all() as $language) {
                if (isset($attributes['name'][$language->code])) {
                    $prepared = [];

                    $prepared['name'] = $attributes['name'][$language->code];
                    $prepared['language_id'] = $language->id;
                    $prepared['tag_id'] = $tag->id;

                    $tag->translations()->create($prepared);
                }
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }

        DB::commit();
        return $tag->load('translations');
    }

    /**
     * @param array $attributes
     * @param array $options
     * @return Tag|null
     */
    public function update(array $attributes = [], array $options = []): ?Tag
    {
        DB::beginTransaction();
        try {
            foreach (Language::all() as $language) {
                if (isset($attributes['name'][$language->code]) || $this->findTranslationByCode($language->code)) {
                    $value = [];
                    $key = [];

                    $value['name'] = $attributes['name'][$language->code] ?? null;
                    $key['language_id'] = $language->id;
                    $key['tag_id'] = $this->id;

                    $translation = $this->findTranslationByCode($language->code) ?? new CategoryTranslation;
                    $translation->updateOrCreate($key, $value);
                }
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
            return null;
        }

        DB::commit();
        return $this->load('translations');
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        DB::beginTransaction();

        try {
            $this->translations()->delete();
            $this->posts()->detach();
            parent::delete();
        } catch (\Exception $exception) {
            DB::rollback();
            return false;
        }

        DB::commit();

        return true;
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->translation()->name ?? $this->engTranslation()->name;
    }
}
