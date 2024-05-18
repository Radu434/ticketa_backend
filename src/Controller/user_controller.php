<?php
require_once "./src/inc/config.php";
require_once './src/Model/User.php';
require_once ("./src/Controller/ControllerTemplate.php");

class UserController extends ControllerTemplate
{

    private $user;

    public function __construct()
    {
        $this->user = new User($GLOBALS['conn']);
    }


    public function processSingleOperation($operation):void
    {
        switch ($operation[1]) {
            case '': {

                echo $this->user->getAll();
                break;
            }
            case 'GET': {
                if (is_numeric($operation[2])) {
                    echo $this->user->getById($operation[2]);
                } else {
                    echo $this->user->getAll();
                }
                break;
            }
            case 'POST': {
                // $this->user->create(['event_id' => 1, 'price' => 20]);
                break;
            }
            case 'PATCH': {

                if (is_numeric($operation[2])) {
                    //  $this->user->update($operation[2], ['event_id' => 12, 'price' => 2340]);
                } else {
                    echo 'Invalid Operation';
                }
                break;
            }
            case 'DELETE': {


                if (is_numeric($operation[2])) {
                    echo $this->user->delete($operation[2]);
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
    public function processGroupOperation($operation):void
    {
        if (count($operation) > 1) {


            switch ($operation[1]) {
                case '': {

                    echo $this->user->getAll();
                    break;
                }

                case 'GET': {

                    echo $this->user->getAll();
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
            echo $this->user->getAll();

        }
    }
}