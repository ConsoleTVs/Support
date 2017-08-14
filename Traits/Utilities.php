<?php

namespace ConsoleTVs\Support\Traits;

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
}
