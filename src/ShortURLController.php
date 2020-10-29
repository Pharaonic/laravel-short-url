<?php

namespace Pharaonic\Laravel\ShortURL;

use App\Http\Controllers\Controller;
use Pharaonic\Laravel\ShortURL\ShortURL;

/**
 * Short URL Controller
 *
 * @version 1.0
 * @author Raggi <support@pharaonic.io>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class ShortURLController extends Controller
{
    /**
     * Redirec to IF NOT Expired
     *
     * @param ShortURL $ShortURL
     * @return void
     */
    public function shortURL(ShortURL $ShortURL)
    {
        // Exipred ?
        if ($ShortURL->expired) return abort(404);

        // Direct To
        return $ShortURL->type == 'url' ? redirect()->to($ShortURL->data['url']) : redirect()->route($ShortURL->data['route'], $ShortURL['params'] ?? []);
    }
}
