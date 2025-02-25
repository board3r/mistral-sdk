<?php

namespace Board3r\MistralSdk\Dto\Response;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\Traits\withChoices;
use Board3r\MistralSdk\Dto\Traits\withCreated;
use Board3r\MistralSdk\Dto\Traits\withId;
use Board3r\MistralSdk\Dto\Traits\withModel;
use Board3r\MistralSdk\Dto\Traits\withObject;
use Board3r\MistralSdk\Dto\Traits\withUsage;

class ChatCompletionResponse extends DataObject
{
    use withId;
    use withModel;
    use withUsage;
    use withCreated;
    use withChoices;
    use withObject;
}
