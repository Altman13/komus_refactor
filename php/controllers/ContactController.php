<?php

use Komus\Contact;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;

class ContactController
{
    private $contact;
    private $resp;

    public function __construct(Container $container)
    {
        $this->contact = $container['contact'];
    }
    public function show()
    {
        return $this->contact->read();
    }

    public function update(Request $request, Response $response)
    {
        try {
            $call = json_decode($request->getBody());
            $this->resp = $this->contact->updateStatusCall($call);
        } catch (\Throwable $th) {
            $response->getBody()->write("Произошла ошибка при добавлении результата звонка "
                . $th->getMessage() . PHP_EOL);
            $this->resp = $response->withStatus(500);
        }
        return $this->resp;
    }
}
