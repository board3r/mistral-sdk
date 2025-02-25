<?php

namespace Board3r\MistralSdk\Dto\Error;

use Board3r\MistralSdk\Dto\Collection;

/**
 * @method Detail offsetGet(int $key)
 * @method Detail get(int $key)
 */
class DetailCollection extends Collection
{
    protected array|string $_dataTypes = Detail::class;
}
