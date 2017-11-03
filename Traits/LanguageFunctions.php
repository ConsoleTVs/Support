<?php

namespace ConsoleTVs\Support\Traits;

use Illuminate\Support\Collection;

trait LanguageFunctions
{
    /**
     * Returns the language list based on a locale.
     *
     * @param  string $locale
     * @return Collection
     */
    public static function languages(string $locale = 'en') : Collection
    {
        return Collection::make(include __DIR__ . "/../../../umpirsky/language-list/data/{$locale}/language.php")->map(function ($lang) {
            return ucfirst($lang);
        });
    }

    /**
     * Returns the language name based on a locale.
     *
     * @param  string $lang
     * @param  string $locale
     * @return string
     */
    public static function language(string $lang = 'en', string $locale = 'en') : string
    {
        return static::languages($locale)->get($lang);
    }
}
