<?php
require_once ("./src/inc/config.php");
require_once './src/Model/event.php';
require_once ("./src/Controller/ControllerTemplate.php");

class EventController extends ControllerTemplate
{
    private $event;
    public function __construct()
    {
        $this->event = new Event($GLOBALS['conn']);
    }


    public function processSingleOperation($parameters): void
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET': {
                $error = true;
                if (array_key_exists('id', $parameters)) {
                    if (is_numeric($parameters['id'])) {
                        $error = false;
                        echo $this->event->getById($parameters["id"]);
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
                        $_PATCH = $this->stringToKVArray(urldecode(file_get_contents('php://input')));
                        if (
                            key_exists('name', $_PATCH) && key_exists('location', $_PATCH)
                            && key_exists('date', $_PATCH) && key_exists('photo', $_PATCH) && key_exists('description', $_PATCH)
                        ) {

                            $this->event->update($parameters['id'], $_PATCH);
                            $error = false;
                            echo json_encode([
                                "message" => "event Updated",
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
                        $this->event->delete($parameters["id"]);
                        echo json_encode([
                            "message" => "event deleted",
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
                echo $this->event->getAll();
                break;
            }
            case "POST": {
                json_decode(file_get_contents('php://input'), true)?$data=json_decode(file_get_contents('php://input'), true):$data = $_POST;
                $id = $this->event->create($data);
                echo json_encode([
                    "message" => "event created",
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