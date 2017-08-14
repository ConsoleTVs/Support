<?php

namespace ConsoleTVs\Support\Traits;

use Illuminate\Support\Collection;

trait Utilities
{
    /**
     * Returns the real client IP adress.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
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
     * Return all the currencies or the one specified.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @param string|null $currency
     * @return Collection
     */
    public static function currencies(string $currency = null) : Collection
    {
        $currency = strtoupper($currency);

        $file = __DIR__ . "/../Assets/Currencies.json";
        $json = json_decode(file_get_contents($file), true);

        if ($currency) {
            return Collection::make($json[$currency]);
        }

        return Collection::make($json);
    }

    /**
     * Returns the most used value in a collection or array.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @param array $array
     * @return [type]
     */
    public static function mostUsed($data) : string
    {
        if (is_a($data, Collection::class)) {
            $data = $data->toArray();
        }

        $count = array_count_values($data);

        return array_search(max($count), $count);
    }
}
