<?php
namespace RMIDatlink\Exceptions;

use RMIDatalink\Enums;

class BaseRuntimeException extends \RuntimeException
{
    private $responseType = "";

    public function getName()
    {
        return 'BaseRuntimeException';
    }

    public function __construct($message, $code=0, $responseType=ResponseTypes::Json) {

        $this->responseType = $responseType;
        //else if($type==Enums\ResponseTypes::Json)

        parent::__construct($message, $code);
    }

    public function errorMessage(){
        return "\r\n".$this->getName() . "[{$this->code}] : {$this->message}\r\n";
    }


}
