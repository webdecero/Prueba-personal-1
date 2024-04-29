<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Webdecero\Package\Core\Casts\KeyCast;
use Webdecero\Package\Core\Casts\BoolCast;
use Webdecero\Package\Core\Traits\BooleanMutators;

class Test  extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'test';

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
        'status' => true,
        'metadata' => [],
    ];



    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'terminal_key', 'key');
    }


    public function groups()
    {
        return $this->hasMany(\App\Models\Group::class, 'terminal_key', 'key');
    }
}
