<?php

namespace App\Models;

use App\Http\Enums\TerminalType;
use MongoDB\Laravel\Eloquent\Model;
use Webdecero\Package\Core\Casts\KeyCast;
use Webdecero\Package\Core\Casts\BoolCast;
use Webdecero\Package\Core\Traits\BooleanMutators;

class Torniquet  extends Model
{

    use BooleanMutators;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'terminals_tourniquet';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        "name",
        "status",
        "deviceId",
        "metadata",
        "locationName"

    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $guarded = [
        "location_key",
        "key"
    ];

    protected $casts = [
        'key' => KeyCast::class,
        'status' => BoolCast::class
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type' => TerminalType::Torniquet->value,
        'status' => true,
        'metadata' => [],
    ];

    // Parents

    public function location()
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_key', 'key');
    }


    // Chidls

    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'terminal_key', 'key');
    }


    public function groups()
    {
        return $this->hasMany(\App\Models\Group::class, 'terminal_key', 'key');
    }


    public function fingerprints()
    {
        return $this->hasMany(\App\Models\Fingerprint::class, 'terminal_key', 'key');
    }
}
