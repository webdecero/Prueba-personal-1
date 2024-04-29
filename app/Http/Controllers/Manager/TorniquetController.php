<?php

namespace App\Http\Controllers\Manager;



use Exception;
use ReflectionClass;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Webdecero\Package\Core\Controllers\Utilities\QueryUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class TorniquetController extends AbstractCoreController
{

    public $prefix = "terminal-torniquet-";
    public function __construct()
    {

        // Cambiar por path de archivo configuración
        $this->initConfig('manager.torniquet');


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
        // $class = new ReflectionClass($this->model);
        // $instance = $class->newInstance();
        // if (!$instance instanceof InterfaceBioParentModelRelationable)
        //     throw new Exception('Model not instace of InterfaceBioParentModelRelationable', 400);


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


            $location = Location::where('key', $input['locationKey'])->first();

            if (empty($location)) return $this->sendError('Not Found Location', 'No se encontro locacion ' . $input['locationKey'], 404);


            // Valide duplicate name
            if (QueryUtilities::isDuplicateRecord($model, 'name', $input['name'])) return $this->sendError('Error de validacion', "The name ". $input['name'] ." has already been taken.", 422);

            // Valide duplicate key
            $keyCatsValue =  QueryUtilities::keyCast($this->prefix . $input['name']);
            if (QueryUtilities::isDuplicateRecord($model, 'key', $keyCatsValue)) return $this->sendError('Error de validacion', "The key {$keyCatsValue} has already been taken in key.", 422);


            $model->fill($input);
            $model->key = $keyCatsValue;
            $model->locationName =  $location->name;

            $model->save();

            $location->registrys()->save($model);

            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {


            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;

            $input = $request->all();

            $validator =  $this->validateByKey($input, __FUNCTION__);

            if (!empty($validator) && $validator->fails()) return $this->sendError('Error de validacion', $validator->errors()->all(), 422);

            $location = Location::where('key', $input['locationKey'])->first();

            if (empty($location)) return $this->sendError('Not Found Location', 'No se encontro locacion ' . $input['locationKey'], 404);

            $model = $modelClass::findOrFail($id);

            // Valide duplicate name
            if (QueryUtilities::isDuplicateRecord($model, 'name', $input['name'], $id)) return $this->sendError('Error de validacion', "The name ".$input['name']." has already been taken.", 422);


            // Valide duplicate key whit id
            $keyCatsValue =  QueryUtilities::keyCast($this->prefix . $input['name']);

            if (QueryUtilities::isDuplicateRecord($model, 'key', $keyCatsValue, $id)) return $this->sendError('Error de validacion', "The key {$keyCatsValue} has already been taken in key.", 422);


            $model->fill($input);
            $model->locationName =  $location->name;

            $model->save();

            $location->registrys()->save($model);


            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {

            return $this->sendApiException($th, __FUNCTION__);
        }
    }

}
