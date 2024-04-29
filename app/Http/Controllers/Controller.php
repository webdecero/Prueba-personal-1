<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Company;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{

    use AuthorizesRequests, ValidatesRequests;

    protected $company = null;
    public function __construct()
    {

    }


}
