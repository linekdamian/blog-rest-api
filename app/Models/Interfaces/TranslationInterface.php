<?php


namespace App\Models\Interfaces;


use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Interface TranslationInterface
 * @package App\Models\Interfaces
 */
interface TranslationInterface
{
    /**
     * @return HasMany
     */
    public function translations(): HasMany;

    /**
     * @return mixed
     */
    public function translation();

    /**
     * @param string $code
     * @return mixed
     */
    public function findTranslationByCode(string $code);
}
