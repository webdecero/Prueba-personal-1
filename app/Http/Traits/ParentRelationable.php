<?php
namespace App\Http\Traits;

use Exception;


trait ParentRelationable
{

    protected function valideParentRelation($parentModelIndex, $configParentRelation = null)
    {

        if ($configParentRelation == null || !isset($configParentRelation['related']) || empty($configParentRelation['related'])) return false;

        $relationModel =  $configParentRelation['related'];

        if (!isset($configParentRelation['foreignKey']) || empty($configParentRelation['foreignKey']))
            throw new Exception('Not found parentRelation foreignKey', 422);

        // $relationForeignKey = $configParentRelation['foreignKey'];


        if (!isset($configParentRelation['otherKey']) || empty($configParentRelation['otherKey']))
            throw new Exception('Not found parentRelation otherKey', 422);

        $relationOtherKey = $configParentRelation['otherKey'];


        $relationRegistry = $relationModel::where($relationOtherKey, $parentModelIndex)->first();

        if (empty($relationRegistry)) return $this->sendError('Not Found relationRegistry', 'No se encontro el registro', 404);

    }
}
