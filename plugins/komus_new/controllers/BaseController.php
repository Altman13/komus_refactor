<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;

class BaseController
{
    private $base;
    public function __construct(Container $container)
    {
        $this->base = $container['base'];
    }
    public function upload(Request $request, Response $response)
    {
        $resp=false;
        $get_file = $request->getUploadedFiles();
        $uploaded_file = $get_file['base_operator'];
        try {
            $this->base->create($uploaded_file);
            $resp=true;
        } catch (\Throwable $th) {
            $response->getBody()->write("Произошла ошибка при загрузке базы " . $th->getMessage() . PHP_EOL);
                $resp = $response->withStatus(500);
        }
        return $resp;

    }
}
