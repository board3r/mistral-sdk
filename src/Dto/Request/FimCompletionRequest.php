<?php

namespace Board3r\MistralSdk\Dto\Request;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\Traits\withMaxTokens;
use Board3r\MistralSdk\Dto\Traits\withMinTokens;
use Board3r\MistralSdk\Dto\Traits\withModel;
use Board3r\MistralSdk\Dto\Traits\withPrompt;
use Board3r\MistralSdk\Dto\Traits\withRandomSeed;
use Board3r\MistralSdk\Dto\Traits\withStop;
use Board3r\MistralSdk\Dto\Traits\withStream;
use Board3r\MistralSdk\Dto\Traits\withSuffix;
use Board3r\MistralSdk\Dto\Traits\withTemperature;
use Board3r\MistralSdk\Enums\ModelEnum;

class FimCompletionRequest extends DataObject
{
    use withModel;
    use withTemperature;
    use withMaxTokens;
    use withStream;
    use withStop;
    use withRandomSeed;
    use withPrompt;
    use withSuffix;
    use withMinTokens;

    protected array $_allowedModels = [ModelEnum::codestral->value, ModelEnum::codestral2405->value];
}
