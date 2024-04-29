<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Webdecero\Package\Core\Traits\BooleanMutators;

class License  extends Model
{

    use BooleanMutators;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'licenses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        "key",
        "type",
        "orderId",
        "serial",
        "file",
        "metadata"
        //company_key
        //location_key
        //terminal_key


    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $casts = [

        // 'quality' => 'integer',
        // 'width' => 'integer',
        // 'height' => 'integer',
        // 'size' => 'integer',


    ];

            /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'metadata' => [],
    ];




}
