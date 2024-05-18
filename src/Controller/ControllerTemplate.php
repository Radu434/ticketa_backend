<?php
abstract class ControllerTemplate
{
    public function parse($operation)
    {
        if(!is_null($operation)) {  
        if (count($operation) > 2) {
            $this->processSingleOperation($operation);

        } else {

            $this->processGroupOperation($operation);

        }
    }
    }
    public abstract function processSingleOperation(array $operation): void;
    public abstract function processGroupOperation(array $operation): void;

}