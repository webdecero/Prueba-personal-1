<?php
namespace App\Models\contracts;

use MongoDB\Laravel\Eloquent\Model;


interface InterfaceParentModelRelationable
{

    public function relationParentModel(Model $related = null, $foreignkey = null, $otherKey = null) ;
}
