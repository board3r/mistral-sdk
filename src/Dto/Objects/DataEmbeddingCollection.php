<?php

namespace Board3r\MistralSdk\Dto\Objects;

use Board3r\MistralSdk\Dto\Collection;

/**
 * @method DataEmbedding offsetGet(int $key)
 * @method DataEmbedding get(int $key)
 */
class DataEmbeddingCollection extends Collection
{
    protected array|string $_dataTypes = DataEmbedding::class;
}
