<?php
require_once ("./src/inc/config.php");
require_once './src/Model/Ticket.php';
require_once ("./src/Controller/ControllerTemplate.php");

class Ticket_Controller extends ControllerTemplate
{
    private $ticket;
    public function __construct()
    {
        $this->ticket = new Ticket($GLOBALS['conn']);
    }


    public function processSingleOperation($parameters): void
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET': {
                $error = true;
                if (array_key_exists('id', $parameters)) {
                    if (is_numeric($parameters['id'])) {
                        $error = false;
                        echo $this->ticket->getById($parameters["id"]);
                    }
                }
                if (array_key_exists('user_id', $parameters)) {
                    if (is_numeric($parameters['user_id'])) {
                        $error = false;
                        echo $this->ticket->getByUserId($parameters["user_id"]);
                    }

                }
                if (array_key_exists('event_id', $parameters)) {
                    if (is_numeric($parameters['event_id'])) {
                        $error = false;
                        echo $this->ticket->getByEvent($parameters["event_id"]);
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
                        if (key_exists('price', $_PATCH) && key_exists('event_id', $_PATCH)) {
                            $this->ticket->update($parameters['id'], $_PATCH);
                            $error = false;
                            echo json_encode([
                                "message" => "Ticket Updated",
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
                        $this->ticket->delete($parameters["id"]);
                        echo json_encode([
                            "message" => "Ticket deleted",
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
                echo json_encode($this->ticket->getAll());
                break;
            }
            case "POST": {
                json_decode(file_get_contents('php://input'), true)?$data=json_decode(file_get_contents('php://input'), true):$data = $_POST;
                $id = $this->ticket->create($data);
                echo json_encode([
                    "message" => "Ticket created",
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