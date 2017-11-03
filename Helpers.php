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

use ConsoleTVs\Support\Traits\Utilities;
use ConsoleTVs\Support\Traits\FileFunctions;
use ConsoleTVs\Support\Traits\StringFunctions;
use ConsoleTVs\Support\Traits\MaterialFunctions;
use ConsoleTVs\Support\Traits\WorldFunctions;
use ConsoleTVs\Support\Traits\LanguageFunctions;

/**
 * ConsoleTVs Helpers class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class Helpers
{
    use Utilities, FileFunctions, StringFunctions, MaterialFunctions, WorldFunctions, LanguageFunctions;
}
