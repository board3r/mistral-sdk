<?php

namespace Board3r\MistralSdk\Dto\Objects;

use Board3r\MistralSdk\Dto\Collection;

/**
 * @method Choice offsetGet(int $key)
 * @method Choice get(int $key)
 */
class ChoiceCollection extends Collection
{
    protected array|string $_dataTypes = Choice::class;
}
