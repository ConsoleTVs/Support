<?php

namespace ConsoleTVs\Support\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait WorldFunctions
{
    /**
     * Returns the country image.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @param string $country
     * @param string $size small|medium|big
     * @return string
     */
    public static function flag(string $country, string $size = 'medium') : string
    {
        $sizes = [
            'small' => 100,
            'medium' => 250,
            'big' => 1000,
        ];

        $code = $country;

        if (strlen($country) > 2) {
            $code = static::countryAlpha2($country);
        }

        $code = strtolower($code);

        if ($code === 'unknown') {
            $flag = __DIR__ . "/../Assets/country-flags/Unknown.png";
        } else {
            $flag = __DIR__ . "/../Assets/country-flags/png{$sizes[$size]}px/{$code}.png";
        }

        $cache_key = "support__flag:{$code}_{$size}";

        if (!Cache::has($cache_key)) {
            $image = Image::make($flag)
                ->resize($sizes[$size], bcmul($sizes[$size], 0.6, 2))
                ->encode('data-url');
            Cache::put($cache_key, $image);
            return $image;
        }

        return Cache::get($cache_key);
    }

    /**
     * Returns the country alpha2 ISO code.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @param string $country
     * @return string
     */
    public static function countryAlpha2(string $country) : string
    {
        $alpha2 = static::simpleCountries()->filter(function ($c) use ($country) {
            return $c === $country;
        })->keys()->first();

        return $alpha2 ? $alpha2 : 'Unknown';
    }

    /**
     * Return the country information based on the accessor.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @param string $country
     * @param string $accessor
     * @param string|null $only_accessor
     * @return Collection
     */
    public static function country(string $country, string $accessor, string $only_accessor = null) : Collection
    {
        $country = strtolower($country);
        $accessor = strtolower($accessor);
        $file = __DIR__ . "/../Assets/topojson/countries/{$country}/{$country}-{$accessor}.json";

        if (!file_exists($file)) {
            return Collection::make([]);
        }

        $json = json_decode(file_get_contents($file), true)['objects'];
        $key = array_keys($json)[0];

        return Collection::make($json[$key]['geometries'])->map(function ($country) use ($only_accessor) {
            if ($only_accessor) {
                return $country['properties'][$only_accessor];
            }

            return $country['properties'];
        });
    }

    /**
     * Return a simple code:country array.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @param string|null $code
     * @return Collection|String
     */
    public static function simpleCountries(string $code = null)
    {
        $file = __DIR__ . "/../Assets/Countries.json";
        $json = json_decode(file_get_contents($file), true);

        if ($code) {
            return $json[$code];
        }

        return Collection::make($json);
    }

    /**
     * Return the countries of the given continent.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @param string $continent
     * @param bool|boolean $only_names
     * @return Collection
     */
    public static function countries(string $continent = null, bool $only_names = false) : Collection
    {
        if (!$continent) {
            return static::getWorldContries($only_names);
        }

        $file = __DIR__ . "/../Assets/topojson/continents/{$continent}.json";

        if (!file_exists($file)) {
            return Collection::make([]);
        }

        $countries = Collection::make(
            json_decode(file_get_contents($file), true)
            ['objects']['continent_' . ucfirst($country) . '_subunits']['geometries']
        )->map(function ($country) {
            return $country['properties'];
        });

        if ($only_names) {
            $countries = $countries->map(function ($country) {
                return $country['geounit'];
            });
        }

        return $countries;
    }

    /**
     * Return the all world countries.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @param boolean $only_names
     * @return Collection
     */
    protected static function getWorldContries($only_names = false) : Collection
    {
        $file = __DIR__ . "/../Assets/topojson/world-countries.json";

        return Collection::make(
            json_decode(file_get_contents($file), true)['objects']['countries1']['geometries']
        )->map(function ($country) use ($only_names) {
            if ($only_names) {
                return $country['properties']['name'];
            }
            return $country['properties'];
        });
    }

    /**
     * Return the world continents.
     *
     * @author Erik Campobadal Fores <soc@erik.cat>
     * @copyright 2017 erik.cat
     * @return Collection
     */
    public static function continents() : Collection
    {
        $file = __DIR__ . "/../Assets/topojson/world-continents.json";

        return Collection::make(
            json_decode(file_get_contents($file), true)['objects']['continent']['geometries']
        )->map(function ($continent) {
            return $continent['properties']['continent'];
        });
    }
}
