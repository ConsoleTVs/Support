<?php

namespace ConsoleTVs\Support\Traits;

use Illuminate\Support\Facades\Request;
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
     * @return string
     */
    public static function mostUsed($data) : string
    {
        if (is_a($data, Collection::class)) {
            $data = $data->toArray();
        }

        $count = array_count_values($data);

        return array_search(max($count), $count);
    }
    
    public static function validGravatar($email) {
        $hash = md5($email);
        $uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
        $headers = @get_headers($uri);
        if (!preg_match("|200|", $headers[0])) {
            return false;
        }
        return true;
    }
    
    /**
     * Return the gavatar for the given email.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @param string $email
     * @param int|integer $size
     * @return string
     */
    public static function gavatar(string $email, int $size = 100) : string
    {
        $hash = md5(strtolower(trim($email)));

        return "https://www.gravatar.com/avatar/{$hash}.jpg?s={$size}";
    }

    /**
     * Returns the seconds in a hour string format.
     *
     * @param float $seconds
     * @return string
     */
    public static function secToHourFormat(float $seconds) : string
    {
        $t = round($seconds);

        return sprintf('%02d:%02d:%02d', ($t/3600), ($t/60%60), $t%60);
    }

    /**
     * Returns if the request URL have an active segment.
     *
     * @param  string   $name
     * @param  int      $segment
     * @param  string   $class
     * @return string
     */
    public static function activeSegUrl(string $name, int $segment = 1, $class = 'active') : string
    {
        return Request::segment($segment) == $name ? $class : '';
    }
}
