<?php

namespace Board3r\MistralSdk\Dto\Error;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\Traits\withObject;

/**
 * @method string getObject()
 * @method string|ValidationError getMessage()
 * @method string getType()
 * @method string|null getParam()
 * @method string|null getCode()
 */
class RequestError extends DataObject implements ErrorInterface
{
    use withObject;

    public string|ValidationError $message;
    public string $type;
    public string|null $param;
    public int|null $code;

    /**
     * Return a formatted message error
     * @return string
     */
    public function getErrorMessage(): string
    {
        if (isset($this->message) && $this->message instanceof ValidationError) {
            return $this->message->getErrorMessage();
        } else {
            return $this->getMessage();
        }
    }
}
