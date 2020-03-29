<?php


use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
class HomeController
{
    protected $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function home($request, $response, $args)
    {
        //$template = $view->render('hello');

        //return new HtmlResponse($template);
        // print htmlspecialchars($request->getBody());
        // $response->getBody()->write("Hello World");
        //$newResponse = $response->withStatus(302);
        //return $newResponse;
        //return $response;
    }

    // public function contact($request, $response, $args)
    // {
    //     return $response;
    // }
}

