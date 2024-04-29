<?php

namespace App\Http\Controllers\Registry;



use Exception;
use App\Models\User;
use App\Models\Company;
use App\Models\Location;
use MongoDB\BSON\ObjectId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Utilities\BiometricsUtilities;
use App\Http\Controllers\SocketIO\SocketIOController;
use Webdecero\Package\Core\Controllers\Utilities\QueryUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class FingerprintController extends AbstractCoreController
{
    private $_fingerPrintDisk;
    protected $prefix = 'fingerprints';
    protected $company = null;

    public function __construct()
    {

        $this->_fingerPrintDisk = Storage::disk('biometrics');
        // Cambiar por path de archivo configuración
        $this->initConfig('registry.fingerprint');
    }


    /**
     * Set configPath de archivo configuración
     * @param string $configPath
     * @param string $configPath
     */
    public function initConfig(String $configPath): string
    {

        $configPath = parent::initConfig($configPath);

        $this->company = Company::first();

        if(empty( $this->company))
            throw new Exception('Not found Company Record', 404);


        return $configPath;
    }




    public function store(Request $request)
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;
            $model = new $modelClass();

            $input = $request->all();

            $validator = $this->validateByKey($input, __FUNCTION__);
            if (!empty($validator) && $validator->fails()) return $this->sendError('Error de validacion', $validator->errors()->all(), 422);


            $user = User::findOrFail($input['userId']);

            $location = Location::where('key', $input['locationKey'])->first();

            if (empty($location)) return $this->sendError('Not Found Location', 'No se encontro locacion ' . $input['locationKey'], 404);

            $terminal =  BiometricsUtilities::getTerminalByType($input['terminalKey'], $input['terminalType']);



            $model->_id  = new ObjectId();
            $model->fill($input);
            $model->terminalName = $terminal->name;
            $model->terminalType = $terminal->type;
            $model->locationName =  $location->name;
            $model->userName =  $user->name;





            $pathStore =  $this->prefix . DIRECTORY_SEPARATOR . $user->id;
            $nameFileImage = ((string)$model->id) . '_image_' . $input['typeHand']  . '_' . $input['typeFinger'] . '.jpg';
            $nameFiletemplate = ((string)$model->id) . '_templete_' . $input['typeHand']  . '_' . $input['typeFinger'] . '.bit';


            $pathImageFingerPrint =  $this->_fingerPrintDisk->putFileAs(
                $pathStore,
                $input['imageFingerPrint'],
                $nameFileImage
            );

            $model->imageFingerPrint = "biometrics" .  DIRECTORY_SEPARATOR . $pathImageFingerPrint;

            $pathTemplateFingerPrint =  $this->_fingerPrintDisk->putFileAs(
                $pathStore,
                $input['templateFingerPrint'],
                $nameFiletemplate
            );
            $model->templateFingerPrint = "biometrics"  . DIRECTORY_SEPARATOR . $pathTemplateFingerPrint;


            $socketIO = new SocketIOController();


            $company = $this->company;
            $db = $company->database;

            $message['dsn'] = $db['dsn'];
            $message['table'] =  $db['table'];

            $message['subjectId'] =  $user->id;
            $message['name'] = $user->name;
            $message['email'] = $user->email;
            $message['terminal_key'] = $terminal->key;
            $message['fingers'] = [];


            $fingerPositionNew = BiometricsUtilities::getValueFinger($model->typeHand, $model->typeFinger);

            //Add new finger
            $message['fingers'] = [[
                'fingerid' => $model->_id,
                'fingerprintPathTemplate' => Storage::path($model->templateFingerPrint),
                'fingerPosition' => $fingerPositionNew
            ]];



            //Add olds fingers
            $fingers = $model::where('user_id', $user->_id)->get();

            foreach ($fingers as $finger) {
                $fingerPosition = BiometricsUtilities::getValueFinger($finger->typeHand, $finger->typeFinger);
                array_push($message['fingers'], [
                    'fingerid' => $finger->id,
                    'fingerprintPathTemplate' => Storage::path($finger->templateFingerPrint),
                    'fingerPosition' => $fingerPosition
                ]);
            }



            $response = $socketIO->connect('subject', 'update', $message);

            //Validación de conexion
            if (!$response['success']) {

                // Storage::delete($model->imageFingerPrint);
                // Storage::delete($model->templateFingerPrint);
                $model->delete();
                throw new Exception($response['messages'], 500);
            }

            $user->fingerprints()->save($model);
            $terminal->fingerprints()->save($model);
            $location->fingerprints()->save($model);

            $model->save();

            return $this->sendResponse($model, __FUNCTION__);
        } catch (Exception $th) {

            return $this->sendApiException($th, __FUNCTION__);
        }
    }


    public function destroy($id)
    {
        try {


            $this->validateScopes(__FUNCTION__);

            $modelClass = $this->model;

            $model = $modelClass::find($id);

            $shortName = $this->reflectionClassModel->getShortName();
            $data = [];

            if (empty($model)) throw new Exception($shortName . ' not found', 404);

            $user = $model->user;

            $socketIO = new SocketIOController();

            $company = $this->company;
            $db = $company->database;

            $message['dsn'] = $db['dsn'];
            $message['table'] =  $db['table'];
            $message['subjectId'] = (string)$user->id;
            $message['fingers'] = [];
            //Get others fingers
            $fingers = $model::where('user_id', $model->user_id)->where('_id', '!=', $model->_id)->get();

            foreach ($fingers as $finger) {
                array_push($message['fingers'], [
                    'fingerid' => $finger->id,
                    'fingerprintPathTemplate' => Storage::path($finger->templateFingerPrint),
                    'fingerPosition' =>  BiometricsUtilities::getValueFinger($finger->typeHand, $finger->typeFinger)
                ]);
            }

            $response = $socketIO->connect('subject', 'update', $message);

            //Validación de conexion
            if (!$response['success']) {
                throw new Exception($response['messages'], 500);
            }



            $data['responseSocket'] = $response;

            if (isset($this->config['destroy']['childs']) && !empty($this->config['destroy']['childs'])) {
                $childs = $this->config['destroy']['childs'];

                foreach ($childs as $key) {
                    $isExist = $this->reflectionClassModel->hasMethod($key);

                    if ($isExist) {
                        $data[$key] = (int) $model->$key()->delete();
                    } else {
                        $data[$key] = 'Not exist function ' . $key;
                    }
                }
            }

            $data[$shortName] = (int)$model->delete();
            return $this->sendResponse($data, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }
}
