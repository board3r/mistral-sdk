<?php

namespace Board3r\MistralSdk\Dto\Objects;

use Board3r\MistralSdk\Dto\Collection;

/**
 * @method Tool offsetGet(int $key)
 * @method Tool get(int $key)
 */
class ToolCollection extends Collection
{
    protected array|string $_dataTypes = Tool::class;
}
