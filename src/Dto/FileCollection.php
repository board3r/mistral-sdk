<?php

namespace Board3r\MistralSdk\Dto;

use Board3r\MistralSdk\Dto\Objects\File;

/**
 * @method File offsetGet(int $key)
 * @method File get(int $key)
 */
class FileCollection extends Collection
{
    protected array|string $_dataTypes = File::class;
}
