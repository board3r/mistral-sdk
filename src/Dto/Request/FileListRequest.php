<?php

namespace Board3r\MistralSdk\Dto\Request;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\Traits\withFilePurpose;
use Board3r\MistralSdk\Dto\Traits\withFileSampleType;
use Board3r\MistralSdk\Dto\Traits\withFileSource;
use Board3r\MistralSdk\Dto\Traits\withPagination;

/**
 * @method self setSearch(string|null $search)
 * @method string|null getSearch()
 */
class FileListRequest extends DataObject
{
    use withPagination;
    use withFileSampleType;
    use withFileSource;
    use withFilePurpose;

    public string|null $search;

}
