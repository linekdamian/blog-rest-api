<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Str;
use App\Models\Interfaces\TranslationInterface;

class Model extends BaseModel implements TranslationInterface
{
    public function setSlug()
    {
        $slug = Str::slug($this->title);
        $counter = 0;

        while ((new static)->where('slug', '=', $slug)->where('id', '!=', $this->id)->count()) {
            $slug = sprintf('%s-%s', Str::slug($this->title), ++$counter);
        }

        return $this->setAttribute('slug', $slug);
    }

    /**
     * @return mixed
     */
    public function translations()
    {
        return;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|HasMany|mixed|object|null
     */
    public function translation()
    {
        if ($this->translations()) {
            $language = Language::findByCode(app('translator')->getLocale());
            return $this->translations()->where('language_id', $language->id)->first() ?? $this->engTranslation();
        } else {
            return null;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|HasMany|object|null
     */
    public function engTranslation()
    {
        if ($this->translations()) {
            return $this->translations()->where('language_id', Language::eng()->id)->first();
        }
    }

    /**
     * @param string $code
     * @return \Illuminate\Database\Eloquent\Model|HasMany|mixed|object|null
     */
    public function findTranslationByCode(string $code)
    {
        if ($this->translations()) {
            return $this->translations()->where('language_id', Language::findByCode($code)->id)->first();
        }
    }
}
