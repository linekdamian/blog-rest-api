<?php


namespace App\Models;


/**
 * Class Language
 * @package App\Models
 */
class Language extends Model
{
    /**
     * @var string
     */
    protected $table = 'languages';

    /**
     * @var array
     */
    protected $fillable = ['code', 'name'];

    /**
     * @param $code
     * @return mixed
     */
    public static function findByCode($code)
    {
        return self::where('code', $code)->first();
    }

    /**
     * @return mixed
     */
    public static function eng()
    {
        return self::where('code', 'en')->first();
    }
}
