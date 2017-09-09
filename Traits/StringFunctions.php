<?php

namespace ConsoleTVs\Support\Traits;

trait StringFUnctions
{
    /**
     * Get a string between two substrings.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @param string $var1
     * @param string $var2
     * @param string $pool
     * @return string
     */
    public static function getBetween(string $var1, string $var2, string $pool) : string
    {
        $temp1 = strpos($pool, $var1) + strlen($var1);
        $result = substr($pool, $temp1, strlen($pool));
        $dd = strpos($result, $var2);
        if ($dd == 0) {
            $dd = strlen($result);
        }

        return substr($result, 0, $dd);
    }

    /**
     * Cleans a string from accents and other things.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @param string $string
     * @return string
     */
    public static function strClean(string $string) : string
    {
        return preg_replace(
            '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml|caron);~i',
            '$1',
            htmlentities($string, ENT_COMPAT, 'UTF-8')
        );
    }
    
    /**
     * Return a random string.
     *
     * @param int $length
     *
     * @return string
     */
    public static function randomString(int $length = 10, string $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') : string
    {
        return substr(str_shuffle(str_repeat($x = $letters, ceil($length / strlen($x)))), 1, $length);
    }
}
