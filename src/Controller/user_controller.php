<?php
require_once ("./src/inc/config.php");
require_once './src/Model/user.php';
require_once ("./src/Controller/ControllerTemplate.php");

class UserControler extends ControllerTemplate
{
    private $user;
    public function __construct()
    {
        $this->user = new User($GLOBALS['conn']);
    }


    public function processSingleOperation($parameters): void
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET': {
                $error = true;
                if (array_key_exists('id', $parameters)) {
                    if (is_numeric($parameters['id'])) {
                        $error = false;
                        echo $this->user->getById($parameters["id"]);
                    }
                }
                if (array_key_exists('email', $parameters) && !(array_key_exists('login', $parameters))) {
                    if (is_string($parameters['email'])) {
                        $error = false;
                        echo $this->user->getByEmail($parameters["email"]);
                    }
                }
                if (array_key_exists('password', $parameters) && !(array_key_exists('login', $parameters))) {
                    if (is_string($parameters['password'])) {
                        $error = false;
                        echo $this->user->getByUsername($parameters["username"]);
                    }
                }
                if (array_key_exists('login', $parameters)) {
                    if (isset($parameters["email"]) && isset($parameters['password'])) {
                        $foundUser = json_decode($this->user->getByEmail($parameters["email"]), true)[0];
                        if ($foundUser["password"] === $parameters["password"]) {
                            $error = false;
                            echo $this->user->getByEmail($parameters["email"]);
                        }
                    }   
                }
                if ($error) {
                    http_response_code(404);
                    echo json_encode([
                        "message" => "Invalid Operation",
                        "operation" => $_SERVER['REQUEST_METHOD'],
                        'parameters' => $parameters
                    ]);
                }
                break;
            }
            case 'PATCH': {
                if (array_key_exists('id', $parameters)) {
                    $error = true;

                    if (is_numeric($parameters['id'])) {
                        $_PATCH = json_decode(file_get_contents('php://input'), true);
                        if (key_exists('email', $_PATCH) && key_exists('username', $_PATCH) && key_exists('password', $_PATCH)) {
                            $this->user->update($parameters['id'], $_PATCH);
                            $error = false;
                            echo json_encode([
                                "message" => "user Updated",
                                "id" => $parameters['id']
                            ]);
                        }

                    }
                    if ($error) {
                        http_response_code(404);
                        echo json_encode([
                            "message" => "Invalid Operation",
                            "operation" => $_SERVER['REQUEST_METHOD'],
                            "parameters" => $parameters
                        ]);
                    }

                }

                break;
            }
            case 'DELETE': {
                $error = true;
                if (array_key_exists('id', $parameters)) {

                    if (is_numeric($parameters['id'])) {
                        $error = false;
                        $this->user->delete($parameters["id"]);
                        echo json_encode([
                            "message" => "user deleted",
                            "id" => $parameters["id"]
                        ]);
                    }
                }
                if ($error) {
                    http_response_code(404);
                    echo json_encode([
                        "message" => "Invalid Operation",
                        "operation" => $_SERVER['REQUEST_METHOD'],
                        'parameters' => $parameters
                    ]);
                }

                break;
            }

            default:
                http_response_code(404);
                echo json_encode([
                    "message" => "Invalid Operation",
                    "operation" => $_SERVER['REQUEST_METHOD'],
                    'parametes' => $parameters
                ]);
                break;

        }
    }
    public function processGroupOperation(): void
    {
        switch ($_SERVER['REQUEST_METHOD']) {

            case 'GET': {
                echo $this->user->getAll();
                break;
            }
            case "POST": {
                json_decode(file_get_contents('php://input'), true) ? $data = json_decode(file_get_contents('php://input'), true) : $data = $_POST;

                $id = $this->user->create($data);
                echo json_encode([
                    "message" => "user created",
                    "id" => $id
                ]);
                break;
            }


            default:
                http_response_code(404);
                echo json_encode([
                    "message" => "Invalid Operation",
                    "operation" => $_SERVER['REQUEST_METHOD']
                ]);
                break;

        }

    }
}