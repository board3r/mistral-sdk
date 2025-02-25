<?php

namespace Board3r\MistralSdk\Dto\Error;

use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method string getDetail()
 * @method string|null getDescription()
 * @method ErrorCollection|Error[]|null getErrors()
 */
class BasicError extends DataObject implements ErrorInterface
{
    public string $detail;
    public string|null $description;
    public ErrorCollection|null $errors;

    /**
     * Return a formatted message error
     * @return string
     */
    public function getErrorMessage(): string
    {
        $message= $this->description??$this>$this->detail;
        if ($this->getErrors()) {
            foreach ($this->getErrors() AS $error){
                $message .= "\nLine ".$error->getLineNumber() ." : ". $error->getMessage();
            }
        }
        return $message;
    }
}
