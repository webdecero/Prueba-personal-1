<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Webdecero\Package\Core\Traits\BooleanMutators;

class Access  extends Model
{

    use BooleanMutators;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'access';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        "type",
        "metadata",
        "dateString",
        //"company_key",
        //"company_name",
        //"location_key",
        //"location_name",
        //"terminal_key",
        //"terminal_name",
        "user_id",
        "user_name",
        //"user_parent_model_id",
        //"access_parent_model_id",
        //"group_key"

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
    public function company_key(){
        return $this->hasOne(\App\Models\Company::class);
    }

    //ToDo: hacer de las locaciones una vez este terminado el modelado

    //ToDo: modificar para que acepte cualquiera de los 3 modelos que ya tenemos (kiosk, torniquet y registry)
    /*
    public function terminal_key(){
        return $this->hasOne(::class,'company_key', 'keyName');
    }
   */
}
