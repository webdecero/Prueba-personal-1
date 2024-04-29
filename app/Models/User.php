<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

// use Illuminate\Foundation\Auth\User as Authenticatable;

// use Laravel\Sanctum\HasApiTokens;

use Laravel\Passport\HasApiTokens;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Webdecero\Package\Core\Casts\BoolCast;
use Webdecero\Package\Core\Casts\ImageObject;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\contracts\InterfaceParentModelRelationable;

class User extends Authenticatable implements InterfaceParentModelRelationable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        "avatar",
        'password',
        "status",
        "address",
        "phone",
        "locations",
        "metadata",
    ];
    protected $guarded = [
        "terminalName",
        "terminalType",
        "terminal_key",


        "parentModelClass",
        "parentModelKey",
        "parentModelIndex",
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'avatar' => ImageObject::class,
        'status'=> BoolCast::class,
        'email_verified_at' => 'datetime'
    ];

    //PARENTS
    public function  group()
    {
        return $this->belongsTo(\App\Models\Group::class);
    }


    public function relationParentModel(Model $related = null, $foreignKey = null, $otherKey = null)
    {

        $parentRelation = config('registry.user.parentRelation');
        $related = empty($related) ? $parentRelation['related'] : $related;
        $foreignKey = empty($foreignKey) ? $parentRelation['foreignKey'] : $foreignKey;
        $otherKey = empty($otherKey) ? $parentRelation['otherKey'] : $otherKey;

        return $this->belongsTo($related, $foreignKey, $otherKey);
    }


    public function locations()
    {
        //TODO: hacer pruebas
        return $this->belongsTo(\App\Models\Location::class, 'locations', 'key')->whereIn('locations',  $this->attributes['locations']);
    }

    public function registry()
    {
        return $this->belongsTo(\App\Models\Registry::class, 'terminal_key', 'key');
    }

    public function kiosk()
    {
        return $this->belongsTo(\App\Models\Kiosk::class, 'terminal_key', 'key');
    }



    // CHILDS

    public function fingerprints()
    {
        return $this->hasMany(\App\Models\Fingerprint::class);
    }

    public function access()
    {
        return $this->hasMany(\App\Models\Access::class);
    }
}
