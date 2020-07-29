<?php

use Komus\Contact;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;

class ContactController
{
    private $contact;
    private $resp;
    private $ret;

    public function __construct(Container $container)
    {
        $this->contact = $container['contact'];
        $this->ret = array('data' => '', 'error' => '', 'error_text' => '');
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
    public function unlock(Request $request, Response $response)
    {
        try {
            $contacts = json_decode($request->getBody());
            $this->resp = $this->contact->unlockContact($contacts);
        } catch (\Throwable $th) {
            $response->getBody()->write("Произошла ошибка при добавлении результата звонка "
                . $th->getMessage() . PHP_EOL);
            $this->resp = $response->withStatus(500);
        }
        return $this->resp;
    }
    public function getContactRusInfo(Request $request, Response $response)
    {
        try {
            $fn = 'columns_name.json';
            $this->resp = file_get_contents($fn);
        } catch (\Throwable $th) {
            $this->resp = "Произошла ошибка при чтении файла $fn " . $th->getMessage().PHP_EOL;
        }
        return $this->resp;
    }
}
