<?php

namespace Board3r\MistralSdk\Dto\Error;

use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method string getMessage()
 * @method int getLineNumber()
 */
class Error extends DataObject
{
    public string|null $message;
    public int|null $lineNumber;
}
