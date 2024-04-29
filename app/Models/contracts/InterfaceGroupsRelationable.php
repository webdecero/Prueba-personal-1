<?php
namespace App\Models\contracts;

use MongoDB\Laravel\Eloquent\Model;




interface InterfaceGroupsRelationable
{



    /**
     * Define a one-to-many relationship with Fingerprints
     * @param string $related
     * @param string $foreignKey
     * @param string $localKey
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups(Model $related = null, $foreignKey = null, $localKey = null);
}
