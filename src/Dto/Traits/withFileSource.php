<?php

namespace Board3r\MistralSdk\Dto\Traits;

use Board3r\MistralSdk\Enums\SourceEnum;
use InvalidArgumentException;

/**
 * @method string|null getSource()
 */
trait withFileSource
{
    public string|null $source;

    public function setSource(string|null $source):self
    {
        if (SourceEnum::tryFrom($source) || is_null($source)) {
            $this->source = $source;
        } else {
            throw new InvalidArgumentException($source.' is not allowed');
        }
        return $this;
    }
}
