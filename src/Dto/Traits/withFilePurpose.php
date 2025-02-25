<?php

namespace Board3r\MistralSdk\Dto\Traits;

use Board3r\MistralSdk\Enums\PurposeEnum;
use DateTime;
use InvalidArgumentException;

/**
 * @method string|null getPurpose()
 */
trait withFilePurpose
{
    public string|null $purpose;

    public function setPurpose(string|null $purpose):self
    {
        if (PurposeEnum::tryFrom($purpose) || is_null($purpose)) {
            $this->purpose = $purpose;
        } else {
            throw new InvalidArgumentException($purpose.' is not allowed');
        }
        return $this;
    }
}
