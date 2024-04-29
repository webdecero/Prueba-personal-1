<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Webdecero\Package\Core\Casts\KeyCast;
use Webdecero\Package\Core\Traits\BooleanMutators;

class Location  extends Model
{

    use BooleanMutators;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        "name",
        "metadata"
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $guarded = [
        "key"
    ];

    protected $casts = [
        'key' => KeyCast::class,
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'metadata' => [],
    ];

    public function registrys()
    {
        return $this->hasMany(\App\Models\Registry::class, 'location_key', 'key');
    }

    // TODO: otras relaciones kiosco
    public function kiosks()
    {
        return $this->hasMany(\App\Models\Kiosk::class, 'location_key', 'key');
    }

    public function torniquets()
    {
        return $this->hasMany(\App\Models\Torniquet::class, 'location_key', 'key');
    }

    public function fingerprints()
    {
        return $this->hasMany(\App\Models\Fingerprint::class, 'location_key', 'key');
    }
}
