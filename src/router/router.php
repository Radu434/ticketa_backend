<?php
include './src/Controller/ticket_controller.php';
include './src/Controller/user_controller.php';
include './src/Controller/event_controller.php';
class Router
{
    private $controllers;
    

    function __construct()
    {
        $this->controllers = ['ticket' => new Ticket_Controller(),'user' => new UserControler(),'event' => new EventController()];
    }
    public function route($route, $operation)
    {
        if (isset($this->controllers[$route])) {
            $this->controllers[$route]->parse($operation);

        } else {
            http_response_code(404);    
            echo json_encode([
                "message" => "Invalid Route",
                "route" => $route,
            ]);
        }
    }
}