<?php
require 'vendor/autoload.php';

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Slim\App;
//use Slim\Factory\AppFactory;
//use Slim\Http\Request;

class Login
{
    protected $container;
    private $db, $app;
    public function __construct($db, ContainerInterface $container, App $app)
    {
        $this->db = $db;
        $this->app = $app;
    }
    public function login()
    {
        $this->app->get('/', function (Request $request/*, Response $response, $args*/) {
            //TODO : добавить валидацию, проверить на пустоту
            $req_body = $request->getBody();
            $users_data = json_decode($req_body);
            $select = $this->db->prepare("SELECT users.password, users.salt FROM users
                                WHERE users.username=:username");
            $select->bindparam(':username', $users_data->user, PDO::PARAM_STR);
            try {
                $select->execute();
            } catch (\Throwable $th) {
                die('Произошла ошибка при выборе пользователя из базы ' . $th->getMessage());
            }
            $data = $select->fetch(PDO::PARAM_STR);
            $check_password = hash('sha256', $users_data->password . $data['salt']);
            if ($check_password === $users_data->password) {
                //TODO : разобраться с token
                $get_users_token = $this->db->prepare("SELECT users.token from users 
                                                WHERE  users.name=:user_name AND users.password=:user_password");
                $get_users_token->bindParam(':user_name', $users_data->user, PDO::PARAM_STR);
                $get_users_token->bindParam(':user_password', $users_data->password, PDO::PARAM_STR);
                try {
                    $get_users_token->execute();
                } catch (\Throwable $th) {
                    die("Произошла ошибка при попытке получить токен пользователя " . $th->getMessage());
                }
                $users_token = $get_users_token->fetch();
                return $users_token;
            } else {
                die('Введенны некорректные данные для авторизации');
            }
        });
        $this->app->run();
    }
    public function logout($user)
    {
        if ($user) {
        }
    }
}
