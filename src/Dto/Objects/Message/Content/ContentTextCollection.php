<?php

namespace Board3r\MistralSdk\Dto\Objects\Message\Content;

use Board3r\MistralSdk\Dto\Collection;

/**
 * @method ContentText offsetGet(int $key)
 * @method ContentText get(int $key)
 */
class ContentTextCollection extends Collection
{
    public array|string $_dataTypes  = ContentText::class;
}
