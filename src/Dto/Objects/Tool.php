<?php

namespace Board3r\MistralSdk\Dto\Objects;

use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method string getType()
 * @method self setType(string $type)
 * @method ToolFunction getFunction()
 * @method self setFunction(array|ToolFunction $function)
 */
class Tool extends DataObject
{
    public string $type = "function";
    public ToolFunction $function;
}
