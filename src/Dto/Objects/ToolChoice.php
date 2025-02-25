<?php

namespace Board3r\MistralSdk\Dto\Objects;

use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method string getType()
 * @method self setType(string $type)
 * @method ToolChoiceFunction getFunction()
 * @method self setFunction(array|ToolChoiceFunction $function)
 */
class ToolChoice extends DataObject
{
    public string $type = "function";
    public ToolChoiceFunction $function;
}
