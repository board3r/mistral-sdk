<?php

namespace Board3r\MistralSdk\Dto\Response;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\Objects\DataEmbedding;
use Board3r\MistralSdk\Dto\Objects\DataEmbeddingCollection;
use Board3r\MistralSdk\Dto\Traits\withId;
use Board3r\MistralSdk\Dto\Traits\withModel;
use Board3r\MistralSdk\Dto\Traits\withObject;
use Board3r\MistralSdk\Dto\Traits\withUsage;

/**
 * @method DataEmbeddingCollection|DataEmbedding[] getData()
 */
class EmbeddingsResponse extends DataObject
{
    use withId;
    use withObject;
    use withModel;
    use withUsage;

    public DataEmbeddingCollection $data;
}
