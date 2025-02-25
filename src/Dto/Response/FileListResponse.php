<?php

namespace Board3r\MistralSdk\Dto\Response;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\FileCollection;
use Board3r\MistralSdk\Dto\Objects\File;
use Board3r\MistralSdk\Dto\Traits\withObject;
use Board3r\MistralSdk\Dto\Traits\withTotal;

/**
 * @method File[]|FileCollection|null getData()
 * @method self setData(array|FileCollection $data)
 */
class FileListResponse extends DataObject
{
    use withObject;
    use withTotal;

    public FileCollection $data;

}
