<?php

namespace Board3r\MistralSdk\Dto\Objects;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Enums\ResponseFormatEnum as ResponseFormatEnum;
use InvalidArgumentException;

/**
 * @method string getType()
 */
class ResponseFormat extends DataObject
{
    public string $type;

    public function setType(string $type): static
    {
        if (ResponseFormatEnum::tryFrom($type)) {
            $this->type = $type;
            return $this;
        }
        throw new InvalidArgumentException($type.' is not allowed');
    }
}
