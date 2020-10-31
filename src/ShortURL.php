<?php

namespace Pharaonic\Laravel\ShortURL;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

/**
 * Short URL Model
 *
 * @version 1.0
 * @author Raggi <support@pharaonic.io>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class ShortURL extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'short_urls';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'code';

    /**
     * The "type" of the primary key Code.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Table Columns
     *
     * @var array
     */
    protected $fillable = ['code', 'type', 'data', 'user_id', 'expire_at'];

    /**
     * Dates
     *
     * @var array
     */
    protected $dates = ['expire_at'];

    /**
     * Casts Columns
     *
     * @var array
     */
    protected $casts = ['data' => 'array'];


    ///////////////////////////////////////////////////////////////
    //
    //                      PRIVATE ACTIONS
    //
    ///////////////////////////////////////////////////////////////

    /**
     * Generate Code
     *
     * @return string
     */
    private function generateCode()
    {
        // Generate Code
        $code = random_bytes(config('Pharaonic.short-url.length', 10) / 2);
        $code = bin2hex($code);

        // Check Unique Code
        if (!$this->isUniqueCode($code)) return $this->generateCode();

        return $code;
    }

    /**
     * Check Code is Unique
     *
     * @return bool
     */
    private function isUniqueCode(string $code)
    {
        return !self::where('code', $code)->exists();
    }

    ///////////////////////////////////////////////////////////////
    //
    //                      Custom Attributes
    //
    ///////////////////////////////////////////////////////////////

    /**
     * Has been Expired
     *
     * @return bool
     */
    public function getExpiredAttribute()
    {
        if (!$this->code || !$this->expire_at) return false;

        return $this->expire_at <= Carbon::now();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getURLAttribute()
    {
        if (!$this->code) return null;

        return route('shortURL', $this->code);
    }

    ///////////////////////////////////////////////////////////////
    //
    //                      PUBLIC ACTIONS
    //
    ///////////////////////////////////////////////////////////////

    /**
     * Get URL
     *
     * @return string
     */
    public function __toString()
    {
        if (!$this->code) return null;

        return $this->url ?? null;
    }

    /**
     * Generate Short URL
     *
     * @param string $route  route or url
     * @param array|string|null $params  route params or expire date
     * @param string|Carbon $expire expire date
     * @return ShortURL
     */
    public function generate(string $route, $params = null, $expire = null)
    {
        $isURL = filter_var($route, FILTER_VALIDATE_URL) !== false;

        // Prepare Args
        if ($isURL && $params) $expire = $params;
        if (!$isURL && !Route::has($route)) throw new Exception("Route name has not been found!");
        if ($expire && !($expire instanceof Carbon)) $expire = Carbon::parse($expire);


        // Create ShortURL
        return self::create([
            'code'      => $this->generateCode(),
            'type'      => $isURL ? 'url' : 'route',
            'data'      => $isURL ? ['url' => $route] : ['route' => $route] + ($params ? ['params' => $params] : []),
            'expire_at' => $expire,
            'user_id'   => auth()->user() ? auth()->user()->id : null
        ]);
    }

    /**
     * Re-Generate Code
     *
     * @return ShortURL|null
     */
    public function regenerate()
    {
        if (!$this->code) return null;

        $this->code = $this->generateCode();
        $this->save();

        return $this;
    }
}
