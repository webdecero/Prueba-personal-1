<?php
namespace App\Http\Controllers\SocketIO;

use Exception;
use Monolog\Logger;
use Psr\Log\LogLevel;
use ElephantIO\Client;
use Illuminate\Http\Request;
use Monolog\Handler\StreamHandler;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Webdecero\Package\Core\Traits\ResponseApi;
use ElephantIO\Exception\SocketException;

class SocketIOController extends Controller
{

    use ResponseApi;
    private $_client;

    protected $config;

    public function __construct()
    {
        $config = config('socketio.socketio');

        $logfile =storage_path('logs/socket.log');

        $logger = new Logger('elephant.io');
        $logger->pushHandler(new StreamHandler($logfile, LogLevel::DEBUG)); // set LogLevel::INFO for brief logging

        $options = [
            'client' =>  Client::CLIENT_4X,
            'transport' => 'websocket',
            'logger' => $logger
        ];

        $this->_client= Client::create($config['url'], $options);
        // $this->_client = new Client(Client::engine($version, $url, $params));
    }

    public function connect($channel, $eventE, Array $data, $eventL = null)
    {
        try {

            $response = [
                'success' => false,
                'messages' => 'Successful socket connection',
            ];

            $this->_client->connect();
            $this->_client->of($channel);

            // emit an event to the server
            $this->_client->emit($eventE, $data);

            if(empty($eventL)) $eventL = $eventE;

            // wait an event to arrive
            if ($packet = $this->_client->wait($eventL)) {

                // an event has been received, the result will be a stdClass
                // data property contains the first argument
                // args property contains array of arguments, [$data, ...]
                // $response['data'] = $packet->data;
                // $response['args'] = $packet->args;
                $response = $packet->data;
            }


            $this->_client->disconnect();

        } catch (Exception $th) {

            $response['success'] = false;
            $response['messages'] = $th->getMessage();

        } finally {

            return $response;

        }
    }

    public function serviceConnect(Request $request)
    {
        try {

            $input = $request->all();

            $rules = [
                'channel' => 'required',
                'eventE' => 'required',
                'data' => 'required|array',
                'eventL' => 'sometimes'
            ];

            $validator = Validator::make($input, $rules);
            if ($validator->fails()) return $this->sendError('validation_error', $validator->errors()->all(), 422);

            $eventL = $request->input('eventL', null);

            $response = $this->connect($input['channel'],$input['eventE'],$input['data'],$eventL);

            if(!$response['success']) return $this->sendError('socket_connection_error', $response['messages'], 400);

            return $this->sendResponse($response['data'], __FUNCTION__);
        }catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }


    public function test(Request $request)
    {
        try {

            $response = [
                'success' => true,
                'messages' => 'Successful socket connection'
            ];

            $this->_client->connect();


        } catch (Exception $th) {

            $response['success'] = false;
            $response['messages'] = $th->getMessage();

        } finally {

            return $response;

        }
    }

}
