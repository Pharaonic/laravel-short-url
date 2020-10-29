<?php

use Pharaonic\Laravel\ShortURL\ShortURL;

/**
 * Short URL (Get OR New)
 *
 * @param string|null $code
 * @return ShortURL
 */
function shortURL(string $code = null) {
    if(!empty($code)) return ShortURL::where('code', $code)->first();

    return new ShortURL;
}
