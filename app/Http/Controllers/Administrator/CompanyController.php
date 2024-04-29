<?php
namespace App\Http\Controllers\Administrator;
use Exception;
use Illuminate\Http\Request;
use Webdecero\Package\Core\Controllers\Utilities\QueryUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class CompanyController extends AbstractCoreController
{

    public function __construct()
    {

        // Cambiar por path de archivo configuración
        $this->initConfig('administrator.company');


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



    /**
     * Display the specified resource.
     *
     * @param  string $key
     * @return \Illuminate\Http\Response
     */
    public function show($key)
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;

            $model = $modelClass::where('key',$key)->first();
            $shortName = $this->reflectionClassModel->getShortName();

            if (empty($model)) throw new Exception($shortName . ' not found', 404);

            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
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

            // Valide duplicate

            if (!empty($model::first())) return $this->sendError('Error de validacion', "The company has already been created.", 422);


            $model->fill($input);
            $model->key = $input['key'];

            $model->save();

            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $key
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key)
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;

            $input = $request->all();

            $validator =  $this->validateByKey($input, __FUNCTION__);

            if (!empty($validator) && $validator->fails()) return $this->sendError('Error de validacion', $validator->errors()->all(), 422);

            $model =  $modelClass::where('key',$key)->first();

            if (empty($model)) return $this->sendError('Error de validacion', "The company not exist", 404);


            $model->fill($input);


            $model->key = $input['key'];
            $model->save();


            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {

            return $this->sendApiException($th, __FUNCTION__);
        }
    }




}
