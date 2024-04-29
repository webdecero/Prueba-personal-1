<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Webdecero\Package\Core\Casts\FileObject;
use Webdecero\Package\Core\Casts\ImageObject;
use Webdecero\Package\Core\Traits\BooleanMutators;

class Fingerprint  extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'fingerprints';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        "typeFinger",
        "typeHand",
        "metadata",

        // "user_id",


    ];

    protected $guarded = [
        "templateFingerPrint",
        "imageFingerPrint",

        "terminalName",
        "terminalType",
        "terminal_key",

        "locationName",
        "location_key",

        "userName",

    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $casts = [
        // "pathImageFingerPrint"=>  FileObject::class,
        // "pathTemplateFingerPrint"=> FileObject::class,

    ];

        /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'metadata' => [],
    ];





    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function location()
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_key', 'key');
    }

    public function registry()
    {
        return $this->belongsTo(\App\Models\Registry::class, 'terminal_key', 'key');
    }

    public function kiosk()
    {
        return $this->belongsTo(\App\Models\Kiosk::class, 'terminal_key', 'key');
    }




}
