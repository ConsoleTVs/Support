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
    public $material_colors = [
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
    public static function clientIP()
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
     * @return Collection | String
     */
    public static function materialColors($color = null)
    {
        $colors = collect($this->material_colors);

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
    public static function materialRound($value)
    {
        if ($value > 999 && $value <= 999999) {
            return floor($value / 1000) . ' K';
        } elseif ($value > 999999) {
            return floor($value / 1000000) . ' M';
        }

        return $value;
    }
}
