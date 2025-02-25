<?php

namespace Board3r\MistralSdk\Dto\Objects;

use Board3r\MistralSdk\Dto\Collection;

/**
 * @method ModerationResult offsetGet(int $key)
 * @method ModerationResult get(int $key)
 */
class ModerationResultCollection extends Collection
{
    protected array|string $_dataTypes = ModerationResult::class;
}
