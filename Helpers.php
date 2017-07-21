<?php
/*
 * This file is part of consoletvs/support.
 *
 * (c) Erik Campobadal <soc@erik.cat>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ConsoleTVs\Support;

use Image;

/**
 * ConsoleTVs Helpers class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class Helpers
{
    /**
     * Material design colors array.
     *
     * @var array
     */
    public static $material_colors = [
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
    ];

    /**
     * Returns the real client IP adress.
     *
     * @author Erik Campobadal <soc@erik.cat>
     *
     * @return string
     */
    public static function clientIP() : string
    {
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
          return $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
          return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Return the material color list or an item inside.
     *
     * @author Erik Campobadal <soc@erik.cat>
     *
     * @param  string $color
     * @return mixed Collection|String
     */
    public static function materialColors(string $color = null)
    {
        $colors = collect(self::$material_colors);

        if (!$color) {
            return $colors;
        }

        return $colors->has($color) ? $colors->get($color) : null;
    }

    /**
     * Rounds the float value with K or M sufixs.
     *
     * @author Erik Campobadal <soc@erik.cat>
     *
     * @param  float $value
     * @return float
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
     * @author Erik Campobadal <soc@erik.cat>
     *
     * @param  string  $name
     * @param  integer $dimensions
     * @param  string  $color
     *
     * @return string
     */
    public static function materialAvatar(string $name, float $dimensions = 100, string $color = null) : string
    {

        $letter = mb_substr($name, 0, 1, 'utf-8');

        if (!$color) {
            $color = static::materialColors()->random();
        }

        $text_position = bcdiv($dimensions, 2, 2);

        return Image::canvas($dimensions, $dimensions, $color)
            ->text($letter, $text_position, $text_position, function ($font) use ($dimensions) {
                $font->file(__DIR__ . '/Assets/fonts/Roboto-Light.ttf')
                    ->size(bcdiv($dimensions, 1.75, 2))
                    ->color('#ffffff')
                    ->align('center')
                    ->valign('middle');
            })
            ->encode('data-url');
    }
}
