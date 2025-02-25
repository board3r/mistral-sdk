<?php

namespace Board3r\MistralSdk\Dto\Objects\Message;

use Board3r\MistralSdk\Dto\Collection;

/**
 * @method ToolCall offsetGet(int $key)
 * @method ToolCall get(int $key)
 */
class ToolCallCollection extends Collection
{
    protected array|string $_dataTypes = ToolCall::class;
}
