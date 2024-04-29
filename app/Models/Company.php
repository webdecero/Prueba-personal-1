<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Webdecero\Package\Core\Casts\KeyCast;
use Webdecero\Package\Core\Casts\BoolCast;
use Webdecero\Package\Core\Casts\ImageObject;
use Webdecero\Package\Core\Traits\BooleanMutators;

class Company extends Model
{

    use BooleanMutators;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'companies';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'isMultiLocation',
        'isGroupActive',
        'resources',
        'status',
        'metadata'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $guarded = [
        'key',
        'database',
    ];

    protected $hidden = [];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'isGroupActive' => true,
        'isMultiLocation' => true,
        'status' => true,
        'metadata' => [],
    ];



    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'key' => KeyCast::class,
        'isGroupActive' =>  BoolCast::class,
        'isMultiLocation' =>  BoolCast::class,
        'status' =>  BoolCast::class,
        'image' => ImageObject::class,
    ];
}
