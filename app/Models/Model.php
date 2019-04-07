<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Str;

class Model extends BaseModel
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
}
