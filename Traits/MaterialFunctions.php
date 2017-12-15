<?php

namespace ConsoleTVs\Support\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

trait MaterialFunctions
{
    /**
     * Return the material color list or an item inside.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @param string|null $color
     * @return mixed Collection|String
     */
    public static function materialColors(string $color = null)
    {
        $colors = Collection::make([
            'red'           => '#F44336',
            'pink'          => '#E91E63',
            'purple'        => '#9C27B0',
            'deep_purple'   => '#673AB7',
            'indigo'        => '#3F51B5',
            'blue'          => '#2196F3',
            'light_blue'    => '#03A9F4',
            'cyan'          => '#00BCD4',
            'teal'          => '#009688',
            'green'         => '#4CAF50',
            'light_green'   => '#8BC34A',
            'lime'          => '#CDDC39',
            'yellow'        => '#FFEB3B',
            'amber'         => '#FFC107',
            'orange'        => '#FF9800',
            'deep_orange'   => '#FF5722',
            'brown'         => '#795548',
            'grey'          => '#9E9E9E',
            'blue_grey'     => '#607D8B'
        ]);

        if (!$color) {
            return $colors;
        }

        return $colors->has($color) ? $colors->get($color) : $color;
    }

    /**
     * Rounds the float value with K or M sufixs.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @param float $value
     * @return float|string
     */
    public static function materialRound(float $value)
    {
        if ($value > 999 && $value <= 999999) {
            return floor($value / 1000) . ' K';
        } elseif ($value > 999999) {
            return floor($value / 1000000) . ' M';
        }

        return $value;
    }

    /**
     * Returns a material design avatar for the given data.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @param string $name
     * @param float|integer $dimensions
     * @param string|null $color
     * @return string
     */
    public static function materialAvatar(string $name, float $dimensions = 100, string $color = null) : string
    {
        $letter = mb_substr($name, 0, 1, 'utf-8');

        if (!$color) {
            $color = static::materialColors()->random();
        } else {
            $color = static::materialColors($color);
        }

        $text_position = bcdiv($dimensions, 2, 2);
        $cache_key = "support__material_avatar:{$letter}_{$dimensions}_{$color}";

        if (!Cache::has($cache_key)) {
            $image = Image::canvas($dimensions, $dimensions, $color)
                ->text($letter, $text_position, $text_position, function ($font) use ($dimensions) {
                    $font->file(__DIR__ . '/../Assets/fonts/Roboto-Light.ttf')
                        ->size(bcdiv($dimensions, 1.75, 2))
                        ->color('#ffffff')
                        ->align('center')
                        ->valign('middle');
                })
                ->encode('data-url');
            Cache::put($cache_key, $image);
            return $image;
        }

        return Cache::get($cache_key);
    }
}
