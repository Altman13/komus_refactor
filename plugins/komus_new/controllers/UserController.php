<?php
require "models/User.php";
use Komus\User;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;

class UserController
{
    private $user;
    public function __construct(Container $container)
    {
        $this->user = $container['user'];
    }
    public function show()
    {

    }
    public function create(Request $request, Response $response)
    {
        $resp='';
        $get_file = $request->getUploadedFiles();
        $uploaded_file = $get_file['operators'];
        try {
            $this->user->create($uploaded_file);
        } catch (\Throwable $th) {
            $response->getBody()->write("Произошла ошибка при загрузке базы " . $th->getMessage() . PHP_EOL);
                $resp = $response->withStatus(500);
        }
        return $resp;
    }
    //TODO: дописать назначение ролей операторам
    public function update($id)
    {
        # code...
    }
}
