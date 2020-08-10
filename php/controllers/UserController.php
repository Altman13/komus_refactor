<?php
require "models/User.php";

use Komus\User;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;

class UserController
{
    private $user;
    private $ret;
    public function __construct(Container $container)
    {
        $this->user = $container['user'];
    }
    public function show()
    {
        $this->ret = $this->user->getAllOperators();
        return $this->ret;
    }
    public function create(Request $request, Response $response)
    {
        try {
            $get_file = $request->getUploadedFiles();
            $uploaded_file = $get_file['upload_file'];
            $this->ret = $this->user->create($uploaded_file, $response);
        } catch (\Throwable $th) {
            $response->getBody()->write("Произошла ошибка при добавлении операторов " . $th->getMessage() . PHP_EOL);
            $this->ret = $response->withStatus(500);
        }
        return $this->ret;
    }

    public function update(Request $request, Response $response)
    {
        try {
            $operator = json_decode($request->getBody());
            $this->ret = $this->user->setStOperator($operator->data);
            if($this->ret == false){
                $this->ret = $response->withStatus(500);
                $response->getBody()->write("Произошла ошибка при назначении старшего оператора " . PHP_EOL);
            }
        } catch (\Throwable $th ) {
            $response->getBody()->write("Произошла ошибка при назначении старшего оператора " . $th->getMessage() . PHP_EOL);
            $this->ret = $response->withStatus(500);
        }
        return $this->ret;
        
    }
}
