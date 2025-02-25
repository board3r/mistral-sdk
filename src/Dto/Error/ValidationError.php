<?php

namespace Board3r\MistralSdk\Dto\Error;

use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method Detail[]|DetailCollection|null getDetail()
 */
class ValidationError extends DataObject implements ErrorInterface
{
    public DetailCollection|null $detail;

    /**
     * Return a formatted message error
     * @return string
     */
    public function getErrorMessage(): string
    {
        $errors = [];
        if ($details = $this->getDetail()) {
            foreach ($details as $detail) {
                $errors[] =  $detail->getType(). ' "'. implode(' > ', $detail->getLoc()) . '" : '. $detail->getMsg();
            }
        }
        return implode("\n", $errors);
    }
}
