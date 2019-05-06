<?php


namespace App\Models;

use App\Scopes\DraftScope;
use App\Models\Translations\PostTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @var array
     */
    protected $fillable = ['draft', 'post_id'];

    /**
     * @var array
     */
    protected $appends = ['title', 'slug', 'body'];

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DraftScope);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->using(Post_Tag::class);
    }

    /**
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(PostTranslation::class);
    }

    /**
     *  @param array $tags
     *  @return void
     */
    public function setTags($tags = [])
    {
        $created = [];

        foreach ($tags as $tag) {
            $newTag = Tag::findByName($tag) ?? Tag::create(['name' => ['en' => $tag]]);

            if (!$newTag->save()) {
                throw new \Exception("Not saved tag");
            }
            $created[] = $newTag->id;
        }

        if (!$this->tags()->sync($created)) {
            throw new \Exception("Not synced tags");
        }
    }

    /**
     * @param array $attributes
     * @return Post|null
     */
    public static function create(array $attributes = []): ?Post
    {
        DB::beginTransaction();
        try {
            $post = new self();
            $post->draft = $attributes['draft'];
            $post->category_id = $attributes['category'];
            $post->save();

            foreach (Language::all() as $language) {
                if (isset($attributes['title'][$language->code])) {
                    $prepared = [];
                    $prepared['title'] = $attributes['title'][$language->code];
                    $prepared['body'] = $attributes['body'][$language->code] ?? null;
                    $prepared['language_id'] = $language->id;
                    $prepared['post_id'] = $post->id;

                    $post->translations()->create($prepared);
                }
            }
            isset($attributes['tags']) ? $post->setTags($attributes['tags']) : $post->setTags();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
            return null;
        }
        DB::commit();
        return $post->load('translations');
    }

    /**
     * @param array $attributes
     * @param array $options
     * @return Post|null
     */
    public function update(array $attributes = [], array $options = []): ?Post
    {
        DB::beginTransaction();

        $this->draft = $attributes['draft'];
        $this->category_id = $attributes['category'];

        try {
            $this->save();

            foreach (Language::all() as $language) {
                if (isset($attributes['title'][$language->code]) || $this->findTranslationByCode($language->code)) {
                    $value = [];
                    $key = [];

                    $value['title'] = $attributes['title'][$language->code] ?? null;
                    $value['body'] = $attributes['body'][$language->code] ?? null;
                    $key['language_id'] = $language->id;
                    $key['post_id'] = $this->id;

                    $translation = $this->findTranslationByCode($language->code) ?? new PostTranslation;
                    $translation->updateOrCreate($key, $value);
                }
            }
            isset($attributes['tags']) ? $this->setTags($attributes['tags']) : $this->setTags();
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
            $this->tags()->detach();
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
     * @return string|null
     */
    public function getTitleAttribute(): ?string
    {
        return $this->translation()->title ?? $this->engTranslation()->title;
    }

    /**
     * @return string|null
     */
    public function getBodyAttribute(): ?string
    {
        return $this->translation()->body ?? $this->engTranslation()->body;
    }

    /**
     * @return string|null
     */
    public function getSlugAttribute(): ?string
    {
        return $this->translation()->slug ?? $this->engTranslation()->slug;
    }
}
