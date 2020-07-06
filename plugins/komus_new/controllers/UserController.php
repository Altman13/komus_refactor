<?php
require "models/User.php";

use Komus\User;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;

class UserController
{
    private $user;
    private $resp;
    public function __construct(Container $container)
    {
        $this->user = $container['user'];
    }
    public function show()
    {
        $this->resp = $this->user->getAllOperators();
        return $this->resp;
    }
    public function create(Request $request, Response $response)
    {
        try {
            $get_file = $request->getUploadedFiles();
            $uploaded_file = $get_file['upload_file'];
            $this->resp = $this->user->create($uploaded_file, $response);
        } catch (\Throwable $th) {
            $response->getBody()->write("Произошла ошибка при добавлении операторов " . $th->getMessage() . PHP_EOL);
            $this->resp = $response->withStatus(500);
        }
        return $this->resp;
    }

    public function update(Request $request, Response $response)
    {
        try {
            $operator = json_decode($request->getBody());
            $this->resp = $this->user->setStOperator($operator->data);
            if(!$this->resp){
                $this->resp = $response->withStatus(500);
                $response->getBody()->write("Произошла ошибка при назначении старшего оператора " . PHP_EOL);
            }
        } catch (\Throwable $th ) {
            $response->getBody()->write("Произошла ошибка при назначении старшего оператора " . $th->getMessage() . PHP_EOL);
            $this->resp = $response->withStatus(500);
        }
        return $this->resp;
        
    }
}
