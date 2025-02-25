<?php

namespace Board3r\MistralSdk\Dto\Response;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\Traits\withId;
use Board3r\MistralSdk\Dto\Traits\withObject;

/**
 * @method bool|null getDeleted()
 */
class FileDeleteResponse extends DataObject
{
    use withId;
    use withObject;

    public bool|null $deleted;
}
