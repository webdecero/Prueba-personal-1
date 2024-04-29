<?php

namespace App\Http\Utilities;


use Exception;

use ReflectionClass;
use App\Models\Kiosk;
use App\Models\Location;
use App\Models\Registry;
use App\Models\Torniquet;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Str;
use App\Http\Enums\TerminalType;
use MongoDB\Laravel\Eloquent\Model;


class BiometricsUtilities
{

    public static function valideParentRelation($parentModelIndex, $parentRelation = null)
    {

        if (!isset($parentRelation['related']) || empty($parentRelation['related']))
            throw new Exception('Not found parentRelation related', 422);

        $model = new ReflectionClass($parentRelation['related']);
        if (!$model->newInstance() instanceof Model)
            throw new Exception($parentRelation['related'] . "  is not instance of MongoDB\Laravel\Eloquent\Model");


        if (!isset($parentRelation['foreignKey']) || empty($parentRelation['foreignKey']))
            throw new Exception('Not found parentRelation foreignKey', 422);

        if (!isset($parentRelation['otherKey']) || empty($parentRelation['otherKey']))
            throw new Exception('Not found parentRelation otherKey', 422);


        $relationModel =  $parentRelation['related'];

        $relationRegistry = $relationModel::where($parentRelation['otherKey'], $parentModelIndex)->first();

        if (empty($relationRegistry)) throw new Exception("Not Found relationRegistry ". $parentRelation['related']." whith ". $parentModelIndex, 404);
    }

    public static function isValideLocations($locationsKeys): bool
    {

        foreach ($locationsKeys as $location) {

            $terminal = Location::where('key', $location)->first();

            if (empty($terminal)) throw new Exception("Not found location {$location}", 404);
        }

        return  true;
    }


    public static function getTerminalByType($terminalKey, $terminalType,  $key = 'key'): Model
    {


        $terminal = null;
        switch ($terminalType) {
            case TerminalType::Kiosk->value:
                $terminal = Kiosk::where($key, $terminalKey)->first();
                break;
            case TerminalType::Registry->value:
                $terminal = Registry::where($key, $terminalKey)->first();
                break;
            case TerminalType::Torniquet->value:
                $terminal = Torniquet::where($key, $terminalKey)->first();
                break;
        }

        if (empty($terminal)) throw new Exception("Not found terminal {$terminalType}:{$terminalKey}", 404);

        return  $terminal;
    }


    public static function getValueFinger(String $hand, String $finger) {
        $value = 0;
        switch ($finger) {
            case 'thumb':
                $value = 1;
                break;
            case 'index':
                $value = 2;
                break;
            case 'middle':
                $value = 3;
                break;
            case 'ring':
                $value = 4;
                break;
            case 'little':
                $value = 5;
                break;
        }
        switch ($hand) {
            case 'right':
                $value += 0;
                break;
            case 'left':
                $value += 5;
                break;
        }

        return  $value;

    }

}
