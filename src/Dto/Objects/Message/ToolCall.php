<?php

namespace Board3r\MistralSdk\Dto\Objects\Message;

use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method string getId()
 * @method self setId(string $id)
 * @method string getType()
 * @method self setType(string $type)
 * @method ToolCallFunction getFunction()
 * @method self setFunction(array|ToolCallFunction $function)
 * @method int getIndex()
 * @method self setIndex(int $index)
 */
class ToolCall extends DataObject
{
    public string $id = "null";
    public string $type = "function";
    public ToolCallFunction $function;
    public int $index = 0;
}
