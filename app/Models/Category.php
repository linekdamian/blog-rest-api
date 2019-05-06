<?php


namespace App\Models;


use App\Models\Translations\CategoryTranslation;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * Class Category
 *
 * @package App\Models
 */
class Category extends Model
{
    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var array
     */
    protected $with = ['posts'];

    /**
     * @var array
     */
    protected $appends = ['name', 'description'];

    /**
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    /**
     * @param array $attributes
     * @return Category|null
     */
    public static function create(array $attributes = []): ?Category
    {
        DB::beginTransaction();
        try {
            $category = new self();
            $category->save();

            foreach (Language::all() as $language) {
                if (isset($attributes['name'][$language->code])) {
                    $prepared = [];

                    $prepared['name'] = $attributes['name'][$language->code];
                    $prepared['description'] = $attributes['description'][$language->code] ?? null;
                    $prepared['language_id'] = $language->id;
                    $prepared['category_id'] = $category->id;

                    $category->translations()->create($prepared);
                }
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }

        DB::commit();
        return $category->load('translations');
    }

    /**
     * @param array $attributes
     * @param array $options
     * @return Category|null
     */
    public function update(array $attributes = [], array $options = []): ?Category
    {
        DB::beginTransaction();
        try {
            foreach (Language::all() as $language) {
                if (isset($attributes['name'][$language->code]) || $this->findTranslationByCode($language->code)) {
                    $value = [];
                    $key = [];

                    $value['name'] = $attributes['name'][$language->code] ?? null;
                    $value['description'] = $attributes['description'][$language->code] ?? null;
                    $key['language_id'] = $language->id;
                    $key['category_id'] = $this->id;

                    $translation = $this->findTranslationByCode($language->code) ?? new CategoryTranslation;
                    $translation->updateOrCreate($key, $value);
                }
            }
        } catch (\Exception $exception) {
            DB::rollBack();
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

    /**
     * @return string
     */
    public function getDescriptionAttribute(): string
    {
        return $this->translation()->description ?? $this->engTranslation()->description;
    }
}
