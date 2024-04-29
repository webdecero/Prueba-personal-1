<?php

namespace App\Http\Controllers\Registry;



use Exception;
use ReflectionClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Utilities\BiometricsUtilities;
use App\Models\contracts\InterfaceParentModelRelationable;
use Webdecero\Package\Core\Controllers\Utilities\QueryUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class GroupController extends AbstractCoreController
{

    public $prefix = "group-";
    public function __construct()
    {

        // Cambiar por path de archivo configuración
        $this->initConfig('registry.group');


    }



    /**
     * Set configPath de archivo configuración
     * @param string $configPath
     * @param string $configPath
     */
    public function initConfig(String $configPath): string
    {

        $configPath = parent::initConfig($configPath);
        // Ejemplo validaciones adicionaes
        $class = new ReflectionClass($this->model);
        $instance = $class->newInstance();
        if (!$instance instanceof InterfaceParentModelRelationable)
            throw new Exception($class->getShortName().' not instace of InterfaceParentModelRelationable', 400);

        return $configPath;
    }



    function store(Request $request)
    {

        try {

            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;
            $model = new $modelClass();

            $input = $request->all();

            $validator = $this->validateByKey($input, __FUNCTION__);
            if (!empty($validator) && $validator->fails()) return $this->sendError('Error de validacion', $validator->errors()->all(), 422);

            BiometricsUtilities::isValideLocations($input['locations']);

            $terminal =  BiometricsUtilities::getTerminalByType($input['terminalKey'], $input['terminalType']);

            // Valide duplicate name
            if (QueryUtilities::isDuplicateRecord($model, 'title', $input['title'])) return $this->sendError('Error de validacion', "The title " . $input['title'] . " has already been taken.", 422);

            // Valide duplicate key
            $keyCatsValue =  QueryUtilities::keyCast($this->prefix . $input['title']);
            if (QueryUtilities::isDuplicateRecord($model, 'key', $keyCatsValue)) return $this->sendError('Error de validacion', "The key {$keyCatsValue} has already been taken in key.", 422);

            $model->fill($input);
            $model->key = $keyCatsValue;
            $model->terminalName = $terminal->name;
            $model->terminalType = $terminal->type;

            $parentRelation = config('registry.group.parentRelation');

            if (!empty($parentRelation) && isset($input['parentModelIndex']) && !empty($input['parentModelIndex'])) {

                BiometricsUtilities::valideParentRelation($input['parentModelIndex'], $parentRelation);

                $model->parentModelClass =   $parentRelation['related'];
                $model->parentModelKey =   $parentRelation['otherKey'];
                $model->parentModelIndex =  $input['parentModelIndex'];
            }

            $model->save();

            $terminal->groups()->save($model);

            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }


    public function update(Request $request, $id)
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;

            $input = $request->all();

            $validator =  $this->validateByKey($input, __FUNCTION__);

            if (!empty($validator) && $validator->fails()) return $this->sendError('Error de validacion', $validator->errors()->all(), 422);

            BiometricsUtilities::isValideLocations($input['locations']);

            $terminal =  BiometricsUtilities::getTerminalByType($input['terminalKey'], $input['terminalType']);

            $model = $modelClass::findOrFail($id);

            // Valide duplicate name
            if (QueryUtilities::isDuplicateRecord($model, 'title', $input['title'], $id)) return $this->sendError('Error de validacion', "The title ".$input['title']." has already been taken.", 422);


            // Valide duplicate key whit id
            $keyCatsValue =  QueryUtilities::keyCast($this->prefix . $input['title']);

            if (QueryUtilities::isDuplicateRecord($model, 'key', $keyCatsValue, $id)) return $this->sendError('Error de validacion', "The key {$keyCatsValue} has already been taken in key.", 422);

            $model->fill($input);
            $model->terminalName = $terminal->name;
            $model->terminalType = $terminal->type;

            $parentRelation = config('registry.group.parentRelation');

            if (!empty($parentRelation) && isset($input['parentModelIndex']) && !empty($input['parentModelIndex'])) {

                BiometricsUtilities::valideParentRelation($input['parentModelIndex'], $parentRelation);

                $model->parentModelClass =   $parentRelation['related'];
                $model->parentModelKey =   $parentRelation['otherKey'];
                $model->parentModelIndex =  $input['parentModelIndex'];
            }

            $model->save();

            $terminal->groups()->save($model);

            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {

            return $this->sendApiException($th, __FUNCTION__);
        }
    }










}
