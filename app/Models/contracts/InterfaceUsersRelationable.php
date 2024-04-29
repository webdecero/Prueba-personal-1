<?php
namespace App\Models\contracts;

use MongoDB\Laravel\Eloquent\Model;



interface InterfaceUsersRelationable
{


    /**
     * Define a one-to-many relationship with users
     * @param string $related
     * @param string $foreignKey
     * @param string $localKey
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(Model $related = null, $foreignKey = null, $localKey = null);

}
