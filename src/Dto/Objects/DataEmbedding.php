<?php

namespace Board3r\MistralSdk\Dto\Objects;

use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method string|null getObject()
 * @method float[]|null getEmbedding()
 * @method int|null getIndex()
 */
class DataEmbedding extends DataObject
{
    public string|null $object;
    public array|null $embedding;
    public int|null $index;
}
