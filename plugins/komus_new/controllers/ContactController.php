<?php
use Komus\Contact;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;
class ContactController
{
    private $contact;
    public function __construct(Container $container)
    {
        $this->contact = $container['contact'];
    }
    public function show()
    {
        echo $this->contact->read();
    }
    public function update(Request $request, Response $response)
    {
        $resp = '';
        if ($request->getAttribute('has_errors')) {
            $errors = $request->getAttribute('errors');
            $response->getBody()->write("Произошла ошибка валидации данных пользователя " . $errors . PHP_EOL);
            $resp = $response->withStatus(500);
        } else {
            $data = json_decode($request->getBody());
            try {
                $id = $data->id;
                $status_call = $data->status_call;
                $resp = $this->contact->updateStatus($id, $status_call);
            } catch (\Throwable $th) {
                $response->getBody()->write("Произошла ошибка при попытке входа на сайт " . $th->getMessage() . PHP_EOL);
                $resp = $response->withStatus(500);
            }
            return $resp;
        }
        
    }
}
