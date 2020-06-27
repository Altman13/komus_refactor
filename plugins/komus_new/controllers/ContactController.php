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
        $data = json_decode($request->getBody());
        $id = $data->id;
        $status_call = $data->status_call;
        $this->contact->updateStatus( $id , $status_call); 
        
    }
}
