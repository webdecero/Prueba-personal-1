<?php
namespace App\Http\Controllers\Registry;


//Facades
use Exception;
use Carbon\Carbon;
//Models
use Illuminate\Http\Request;

//Class
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Webdecero\Manager\Api\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Webdecero\Package\Core\Controllers\Core\AbstractCoreController;

class LoginController extends AbstractCoreController
{

    protected $redirectAuth;

    public function __construct()
    {

        $this->redirectAuth = config('registry.admin.login.redirectAuth', '/');
    }

    public function login(Request $request)
    {

        try {

            $rules = array(
                'email' => array('required', 'email'),
                'password' => array('required', 'min:6'),
            );

            $input = $request->all();

            $validator = Validator::make($input, $rules);

            if ($validator->fails())   return $this->sendError('Validator', $validator->errors()->all(), 422);


            $admin = $this->_adminAuthentication($input['email'], $input['password']);



            if (!$admin)
                return $this->sendError('Authentication', trans('Credenciales incorrectas'), 403);


            return $this->sendResponse($this->_createAccesTokenResponse($admin), __FUNCTION__);
        } catch (Exception $th) {

            return $this->sendApiException($th, __FUNCTION__);
        }
    }


    public function logout(Request $request)
    {

        try {

            if (!Auth::check())   return $this->sendError('Validator', 'Administrador no encontrado', 404);



            $admin = Auth::user();
            $admin->token()->delete();


            // $token = Auth::user()->token();
            // $token->revoke();
            // dd($admin);


            return $this->sendResponse($admin, __FUNCTION__);
        } catch (Exception $th) {


            return $this->sendApiException($th, __FUNCTION__);
        }
    }

    private function _adminAuthentication($email, $password, $status = true)
    {

        $credentials = [
            'email' => $email,
            'status' => $status,
        ];

        $admin = Admin::where($credentials)->first();


        return $admin && Hash::check($password, $admin->password) ? $admin : false;
    }

    private function _createAccesTokenResponse($user, $menssage = 'Personal Access Token Registry')
    {
        if (empty($user->scopes)) {
            $user->scopes = ['*'];
        }

        $tokenResult = $user->createToken($menssage,  $user->scopes)->accessToken;


        return [
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'redirectAuth' => $this->redirectAuth
        ];
    }
}
