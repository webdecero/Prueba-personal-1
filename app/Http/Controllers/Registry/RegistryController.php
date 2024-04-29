<?php

namespace App\Http\Controllers\Registry;



use Exception;
use ReflectionClass;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Enums\TerminalType;
use Illuminate\Support\Facades\Validator;
use App\Http\Utilities\BiometricsUtilities;
use Webdecero\Package\Core\Controllers\Utilities\QueryUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class RegistryController extends AbstractCoreController
{

    protected $version = null;
    protected $company = null;
    protected $prefixTerminal= 'registry';

    public function __construct()
    {
        // Cambiar por path de archivo configuración
        $this->initConfig("{$this->prefixTerminal}.terminal");
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

        if (empty($this->company))
            throw new Exception('Not found Company Record', 404);


        $this->version = config("{$this->prefixTerminal}.version");

        if (empty($this->version))
            throw new Exception('Not found config version terminal', 404);

        return $configPath;
    }



    function setup(Request $request)
    {

        try {


            $modelClass = $this->model;
            $model = new $modelClass();

            $input = $request->all();


            $validator = $this->validateByKey($input, __FUNCTION__);
            if (!empty($validator) && $validator->fails()) return $this->sendError('Error de validacion', $validator->errors()->all(), 422);


            $terminal = $model::where('key', $input['terminalKey'])->first();


            if (empty($terminal)) return $this->sendError('Not Found terminal', 'No se encontro terminal:' . $input['terminalKey'], 404);


            // if (!$terminal->status) return $this->sendError('Terminal Status False', "La terminal  {$terminal->name} se encuentra desactivada", 400);


            if (!isset($terminal->deviceId) || $terminal->deviceId == null || empty($terminal->deviceId)) {

                $terminal->deviceId = $input['deviceId'];
                $terminal->save();
            } else if ($terminal->deviceId != $input['deviceId']) {

                return $this->sendError('DeviceId', 'Error deviceId: ' . $terminal->deviceId, 422);
            }


            $location = $terminal->location;

            if (empty($location)) throw new Exception('Not found location Record', 404);


            $version = config('registry.version');


            if (!isset($version[$input['version']]) || empty($version[$input['version']]))
                return $this->sendError('Not Found version', 'No se encontro version: ' . $input['version'], 404);

            $cf = $version[$input['version']];

            //TODO: configuración notifications

            $cf["company"] = [
                "key" => $this->company->key,
                "name" => $this->company->name,
                "isMultiLocation" => $this->company->isMultiLocation,
                "isGroupActive" => $this->company->isGroupActive,
                "status" => $this->company->status,
                "metadata" => $this->company->metadata ?? []
            ];

            $cf["location"] = [
                "key" => $location->key,
                "name" => $location->name,
                "metadata" => $location->metadata ?? []
            ];
            $cf["terminal"] = [
                "id" => $terminal->id,
                "key" => $terminal->key,
                "name" => $terminal->name,
                "status" => $terminal->status,
                "deviceId" => $terminal->deviceId,
                "metadata" => $terminal->metadata ?? []
                // "isSensorFingerprint" => $terminal->isSensorFingerprint,
                // "isSensorCamera" => $terminal->isSensorCamera,
                // "isServerNotification" => $terminal->isServerNotification,
            ];


            $cf["api"] = [
                "host" => url('/') . '/'
            ];



            return $this->sendResponse($cf, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }
}
