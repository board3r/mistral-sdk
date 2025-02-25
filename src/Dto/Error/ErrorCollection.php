<?php

namespace Board3r\MistralSdk\Dto\Error;

use Board3r\MistralSdk\Dto\Collection;
/**
 * @method Error offsetGet(int $key)
 * @method Error get(int $key)
 */
class ErrorCollection extends Collection
{
    protected array|string $_dataTypes = Error::class;
}
