<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Webdecero\Package\Core\Traits\BooleanMutators;

class Bancomer extends Model
{

    use BooleanMutators;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'bancomer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'status',
        'metadata',

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

}
