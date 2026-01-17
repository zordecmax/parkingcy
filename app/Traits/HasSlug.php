<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        static::creating(function ($model) {
            $model->slug = $model->generateSlug();
        });
    }

    public function generateSlug()
    {
        $slug = Str::slug($this->attributes['name']);

        $originalSlug = $slug;
        $counter = 1;

        while (static::whereSlug($slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
