<?php

namespace Board3r\MistralSdk\Dto\Objects;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\Traits\withFileInfo;
use Board3r\MistralSdk\Dto\Traits\withFilename;
use Board3r\MistralSdk\Dto\Traits\withFilePurpose;
use Board3r\MistralSdk\Dto\Traits\withFileSampleType;
use Board3r\MistralSdk\Dto\Traits\withFileSource;
use Board3r\MistralSdk\Dto\Traits\withId;
use Board3r\MistralSdk\Dto\Traits\withObject;

class File extends DataObject
{
    use withId;
    use withObject;
    use withFilename;
    use withFileInfo;
    use withFileSource;
    use withFilePurpose;
    use withFileSampleType;

}
