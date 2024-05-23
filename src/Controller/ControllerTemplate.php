<?php

abstract class ControllerTemplate
{
    public function formatParameters($parameters)
    {
        $array = explode('&', $parameters);
        $result = array();
        for ($i = 0; $i < count($array); $i++) {
            $keyValue = explode('=', $array[$i]);
            $key = $keyValue[0];
            $value = isset($keyValue[1]) ? $keyValue[1] : '';
            $kvpair[$key] = $value;
            $result[$i] = $kvpair;
            $kvpair = array();
        }
        return $result;
    }
    public function stringToKVArray($parameters)
    {
        
        $array = explode('&', $parameters);
        $result = array();
        for ($i = 0; $i < count($array); $i++) {
            $keyValue = explode('=', $array[$i]);
            $key = $keyValue[0];
            $value = isset($keyValue[1]) ? $keyValue[1] : 0;
            $result[$key] = $value;

        }
        return $result;
    }
    public function parse($parameters)
    {
        if ($parameters != '') {

            $this->processSingleOperation($this->stringToKVArray(urldecode($parameters)));


        } else {

            $this->processGroupOperation();

        }
    }
    public abstract function processSingleOperation(array $parameters): void;
    public abstract function processGroupOperation(): void;

}