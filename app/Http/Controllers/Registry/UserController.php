<?php

namespace App\Http\Controllers\Registry;



use Exception;
use ReflectionClass;
use App\Models\Kiosk;
use App\Models\Company;
use App\Models\Registry;
use Illuminate\Http\Request;
use App\Http\Traits\ParentRelationable;
use Illuminate\Support\Facades\Validator;
use App\Http\Utilities\BiometricsUtilities;
use App\Http\Controllers\SocketIO\SocketIOController;
use App\Models\contracts\InterfaceParentModelRelationable;
use Webdecero\Package\Core\Controllers\Utilities\QueryUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class UserController extends AbstractCoreController
{

    use ParentRelationable;

    protected $company = null;


    public function __construct()
    {
        // Cambiar por path de archivo configuración
        $this->initConfig('registry.user');
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
            throw new Exception($class->getShortName() . ' not instace of InterfaceParentModelRelationable', 400);


        $this->company = Company::first();

        if (empty($this->company))
            throw new Exception('Not found Company Record', 404);


        return $configPath;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

            // Valide duplicate email
            if (QueryUtilities::isDuplicateRecord($model, 'email', $input['email'])) return $this->sendError('Error de validacion', "The email " . $input['email'] . " has already been taken.", 422);


            $model->fill($input);
            $model->terminalName = $terminal->name;
            $model->terminalType = $terminal->type;

            $parentRelation = config('registry.user.parentRelation');

            if (!empty($parentRelation) && isset($input['parentModelIndex']) && !empty($input['parentModelIndex'])) {

                BiometricsUtilities::valideParentRelation($input['parentModelIndex'], $parentRelation);

                $model->parentModelClass =   $parentRelation['related'];
                $model->parentModelKey =   $parentRelation['otherKey'];
                $model->parentModelIndex =  $input['parentModelIndex'];
            }

            $model->save();

            $terminal->users()->save($model);
            //TODO: falta relacion grupo


            $socketIO = new SocketIOController();


            $company = $this->company;
            $db = $company->database;



            $message['dsn'] = $db['dsn'];
            $message['table'] =  $db['table'];

            $message['subjectId'] =  $model->id;
            $message['email'] =  $model->email;
            $message['name'] = $model->name;
            $message['terminal_key'] = $terminal->key;

            $response = $socketIO->connect('subject', 'store', $message);

            //Validación de conexion
            if (!$response['success']) {
                $model->delete();
                throw new Exception($response['messages']);
            }

            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {

            return $this->sendApiException($th, __FUNCTION__);
        }
    }

    //TODO: leer primero el registro subject y depues

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
            // Valide duplicate email
            if (QueryUtilities::isDuplicateRecord($model, 'email', $input['email'], $id)) return $this->sendError('Error de validacion', "The email " . $input['email'] . " has already been taken.", 422);



            $model->fill($input);
            $model->terminalName = $terminal->name;
            $model->terminalType = $terminal->type;

            $parentRelation = config('registry.user.parentRelation');

            if (!empty($parentRelation) && isset($input['parentModelIndex']) && !empty($input['parentModelIndex'])) {

                BiometricsUtilities::valideParentRelation($input['parentModelIndex'], $parentRelation);

                $model->parentModelClass =   $parentRelation['related'];
                $model->parentModelKey =   $parentRelation['otherKey'];
                $model->parentModelIndex =  $input['parentModelIndex'];
            }

            $model->save();

            $terminal->users()->save($model);

            //TODO: falta relacion grupo

            $socketIO = new SocketIOController();

            $company = $this->company;
            $db = $company->database;

            // SocketIO ajustes

            $message['dsn'] = $db['dsn'];
            $message['table'] =  $db['table'];

            $message['subjectId'] =  $model->id;
            $message['name'] = $model->name;
            $message['email'] = $model->email;
            $message['terminal_key'] = $terminal->key;
            $message['fingers'] = [];

            $response = $socketIO->connect('subject', 'update', $message);

            //Validación de conexion
            if (!$response['success']) throw new Exception($response['messages']);


            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {

            return $this->sendApiException($th, __FUNCTION__);
        }
    }
}
