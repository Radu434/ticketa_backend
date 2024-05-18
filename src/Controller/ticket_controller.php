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


    public function processSingleOperation($operation): void
    {
        switch ($operation[1]) {
            case '': {

                echo $this->ticket->getAll();
                break;
            }
            case 'GET': {
                if (is_numeric($operation[2])) {
                    echo $this->ticket->getById($operation[2]);
                } else {
                    if ($operation[2] == 'user'&&count($operation)>3) {
                        if(is_numeric($operation[3])){
                            echo $this->ticket->getByUserId($operation[3]);

                        }
                        else{
                            echo 'Invalid Operation';
                        }
                    } else {
                        echo $this->ticket->getAll();

                    }
                }
                break;
            }
            case 'POST': {
                $this->ticket->create(['event_id' => 1, 'price' => 20]);
                break;
            }
            case 'PATCH': {

                if (is_numeric($operation[2])) {
                    $this->ticket->update($operation[2], ['event_id' => 12, 'price' => 2340]);
                } else {
                    echo 'Invalid Operation';
                }
                break;
            }
            case 'DELETE': {


                if (is_numeric($operation[2])) {
                    echo $this->ticket->delete($operation[2]);
                } else {
                    echo 'Invalid deletion id';
                }

                break;
            }


            default:
                echo 'Invalid Operation';
                break;

        }
    }
    public function processGroupOperation($operation): void
    {
        if (count($operation) > 1) {


            switch ($operation[1]) {
                case '': {

                    echo $this->ticket->getAll();
                    break;
                }

                case 'GET': {

                    echo $this->ticket->getAll();
                    break;
                }
                case 'POST': {

                    break;
                }


                default:
                    echo 'Invalid Operation';
                    break;

            }
        } else {
            echo $this->ticket->getAll();

        }
    }
}