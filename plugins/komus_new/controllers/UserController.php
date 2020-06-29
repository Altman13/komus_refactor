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
        $this->resp = $this->user->read();
        return $this->resp;
    }
    public function create(Request $request, Response $response)
    {
        try {
            $get_file = $request->getUploadedFiles();
            $uploaded_file = $get_file['upload_file'];
            $this->user->create($uploaded_file);
        } catch (\Throwable $th) {
            $response->getBody()->write("Произошла ошибка при добавлении операторов " . $th->getMessage() . PHP_EOL);
            $this->resp = $response->withStatus(500);
        }
        return $this->resp;
    }
    //TODO: дописать назначение ролей операторам
    public function update($id)
    {
        # code...
    }
}
