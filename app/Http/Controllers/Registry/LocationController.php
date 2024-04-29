<?php

namespace App\Http\Controllers\Manager;



use Exception;
use ReflectionClass;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Webdecero\Package\Core\Controllers\Utilities\QueryUtilities;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class LocationController extends AbstractCoreController
{

    public function __construct()
    {

        // Cambiar por path de archivo configuración
        $this->initConfig('registry.location');
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



}
