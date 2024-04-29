<?php
namespace App\Http\Controllers\Registry;


use Exception;
use ReflectionClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;
use Illuminate\Support\Facades\Validator;

class AdminController extends AbstractCoreController
{

    public function __construct()
    {

        // Cambiar por path de archivo configuración
        $this->initConfig('registry.admin');
    }



    /**
     * Set configPath de archivo configuración
     * @param string $configPath
     * @param string $configPath
     */
    public function initConfig(String $configPath): string
    {

        $configPath = parent::initConfig($configPath);


        return $configPath;
    }


    public function info()
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $admin = Auth::user();
            if (empty($admin))   return $this->sendError(__METHOD__, 'Usario no encontrado', 404);




            return $this->sendResponse($admin, __FUNCTION__);
        } catch (Exception $th) {

            return $this->sendApiException($th, __METHOD__);
        }
    }


}
