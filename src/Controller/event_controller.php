<?php
require_once ("./src/inc/config.php");
require_once './src/Model/Event.php';
require_once ("./src/Controller/ControllerTemplate.php");

class EventController extends ControllerTemplate
{
    private $event;
    public function __construct()
    {
        $this->event = new Event($GLOBALS['conn']);
    }


    public function processSingleOperation($operation): void
    {
        switch ($operation[1]) {
            case '': {

                echo $this->event->getAll();
                break;
            }
            case 'GET': {
                if (is_numeric($operation[2])) {
                    echo $this->event->getById($operation[2]);
                } else {
                    echo $this->event->getAll();
                }
                break;
            }
            case 'POST': {
              //  $this->event->create(['event_id' => 1, 'price' => 20]);
                break;
            }
            case 'PATCH': {

                if (is_numeric($operation[2])) {
                   // $this->event->update($operation[2], ['event_id' => 12, 'price' => 2340]);
                } else {
                    echo 'Invalid Operation';
                }
                break;
            }
            case 'DELETE': {


                if (is_numeric($operation[2])) {
                    echo $this->event->delete($operation[2]);
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

                    echo $this->event->getAll();
                    break;
                }

                case 'GET': {

                    echo $this->event->getAll();
                    break;
                }
                case 'POST': {

                    break;
                }


                default:
                    echo 'Invalid Operation';
                    break;

            }
        }
        else{
            echo $this->event->getAll();

        }
    }
}